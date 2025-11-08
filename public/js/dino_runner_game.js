document.addEventListener("DOMContentLoaded", () => {
  const canvas = document.getElementById("game-canvas");
  const ctx = canvas.getContext("2d");
  const dinoSelectorGallery = document.getElementById("dino-selector-gallery");
  const dinoSelectorCards = document.querySelectorAll(".dino-card");
  const startBtn = document.getElementById("start-game-btn");
  const gameContainer = document.getElementById("game-container");
  const headerElements = document.querySelectorAll(
    ".minigame-title, .minigame-subtitle"
  );
  const muteBtn = document.getElementById("mute-btn");
  const changeMusicBtn = document.getElementById("change-music-btn");

  const AVERAGE_WEIGHT = 60;
  const SPRITE_WIDTH = 32;
  const SPRITE_HEIGHT = 32;
  const ANIMATION_SPEED = 8;
  const GAME_FONT = '"Press Start 2P"';
  const INVINCIBILITY_DURATION = 120;
  
  const musicOriginal = new Audio("/draftosaurus/public/audio/background-music.mp3");
  musicOriginal.loop = true;
  musicOriginal.volume = 0.4;
  const musicRemix = new Audio("/draftosaurus/public/audio/background-music-remix.mp3");
  musicRemix.loop = true;
  musicRemix.volume = 0.4;
  
  let currentMusic = musicOriginal;

  const jumpSound = new Audio("/draftosaurus/public/audio/jump-sound.mp3");
  jumpSound.volume = 1.0;
  const hitSound = new Audio("/draftosaurus/public/audio/hit-sound.mp3");
  hitSound.volume = 1.0;

  const heartImage = new Image();
  heartImage.src = '/draftosaurus/public/img/heart.png';

  let isMuted = false;
  let selectedDinoData = null;
  let gameRunning = false;
  let animationFrameId;
  let score = 0,
    highScore = localStorage.getItem("dinoRunnerHighScore") || 0;
  let gameFrame = 0;
  let gameSpeed;
  let obstacles = [];
  let obstacleTimer = 0;

  const spriteCache = {};
  dinosaurs_data.forEach((dino) => {
    const img1 = new Image();
    img1.src = `/draftosaurus/public/img/sprites/${dino.sprite_frame1}`;
    const img2 = new Image();
    img2.src = `/draftosaurus/public/img/sprites/${dino.sprite_frame2}`;
    spriteCache[dino.species] = [img1, img2];
  });

  const player = {
    x: 50, y: canvas.height - SPRITE_HEIGHT, width: SPRITE_WIDTH, height: SPRITE_HEIGHT,
    velocityY: 0, isJumping: false, spriteFrames: [], maxSpeed: 0, jumpPower: 0, gravity: 0,
    lives: 3,
    isInvincible: false,
    invincibilityTimer: 0,
    isChargingJump: false,
    jumpCharge: 0,

    draw() {
      if (this.spriteFrames.length < 2) return;
      const frameIndex = Math.floor(gameFrame / ANIMATION_SPEED) % this.spriteFrames.length;
      const imageToDraw = this.spriteFrames[frameIndex];
      
      if (imageToDraw && imageToDraw.complete) {
        if (this.isInvincible && Math.floor(gameFrame / 6) % 2 !== 0) {
          ctx.save();
          ctx.drawImage(imageToDraw, Math.floor(this.x), Math.floor(this.y), this.width, this.height);
          ctx.globalCompositeOperation = 'source-in';
          ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
          ctx.fillRect(Math.floor(this.x), Math.floor(this.y), this.width, this.height);
          ctx.restore();
        } else {
          ctx.drawImage(imageToDraw, Math.floor(this.x), Math.floor(this.y), this.width, this.height);
        }
      }
    },
    jump() {
      if (!this.isJumping) {
        jumpSound.currentTime = 0;
        jumpSound.volume = 0.5 + (this.jumpCharge * 0.5);
        jumpSound.play();
        this.isJumping = true;
        const minJumpForce = 0.3;
        const finalImpulse = this.jumpPower * (minJumpForce + this.jumpCharge * (1 - minJumpForce));
        this.velocityY = finalImpulse;
        this.isChargingJump = false;
        this.jumpCharge = 0;
      }
    },
    update() {
      if (this.isJumping) {
        this.y += this.velocityY;
        this.velocityY += this.gravity;
        if (this.y > canvas.height - this.height) {
          this.y = canvas.height - this.height;
          this.isJumping = false;
          this.velocityY = 0;
        }
      }
      if (this.isInvincible) {
        this.invincibilityTimer--;
        if (this.invincibilityTimer <= 0) {
          this.isInvincible = false;
        }
      }

      if (this.isChargingJump) {
        if (this.jumpCharge < 1) {
          this.jumpCharge += 0.05; 
        }
      }
    }
  };
    
  dinoSelectorCards.forEach((card) => {
    const dinoId = card.dataset.id;
    const dinoData = dinosaurs_data.find(d => d.dino_id == dinoId);
    const tooltip = card.querySelector('#dino-tooltip');
    card.addEventListener('mouseover', () => {
      if (!dinoData) return;
      const weight = parseFloat(dinoData.weight);
      const maxSpeed = 4 + 80 / weight;
      const jumpPower = -12 - 60 / weight;
      const gravity = 0.5 * (weight / AVERAGE_WEIGHT);
      tooltip.innerHTML = `<strong>${dinoData.species}</strong><hr class="my-1"><ul class="list-unstyled mb-0"><li><strong>Peso:</strong> ${weight.toFixed(0)} kg</li><li><strong>Velocidad Máx:</strong> ${maxSpeed.toFixed(2)}</li><li><strong>Potencia Salto:</strong> ${Math.abs(jumpPower).toFixed(2)}</li><li><strong>Gravedad:</strong> ${gravity.toFixed(2)}</li></ul>`;
    });
    card.addEventListener('click', () => {
      dinoSelectorCards.forEach(c => c.classList.remove('selected'));
      card.classList.add('selected');
      selectedDinoData = dinoData;
      startBtn.disabled = false;
    });
  });

  startBtn.addEventListener('click', () => {
    if (!selectedDinoData) return;
    currentMusic.play();
    headerElements.forEach(el => el.style.display = 'none');
    dinoSelectorGallery.style.display = 'none';
    changeMusicBtn.style.display = 'none';
    startBtn.style.display = 'none';
    gameContainer.style.display = 'block';
    initializeGame();
    startGame();
  });
    
  muteBtn.addEventListener('click', () => {
    isMuted = !isMuted;
    musicOriginal.muted = isMuted;
    musicRemix.muted = isMuted;
    jumpSound.muted = isMuted;
    hitSound.muted = isMuted;
    muteBtn.src = isMuted ? '/draftosaurus/public/img/icon-volume-off.png' : '/draftosaurus/public/img/icon-volume-on.png';
  });

  changeMusicBtn.addEventListener('click', () => {
      if (currentMusic === musicOriginal) {
          currentMusic = musicRemix;
          changeMusicBtn.textContent = 'Música: Remix';
      } else {
          currentMusic = musicOriginal;
          changeMusicBtn.textContent = 'Música: Original';
      }
  });

  document.addEventListener('keydown', e => {
    if ((e.code === 'Space' || e.code === 'ArrowUp') && gameRunning && !player.isJumping && !player.isChargingJump) {
      player.isChargingJump = true;
    }
  });
  document.addEventListener('keyup', e => {
    if ((e.code === 'Space' || e.code === 'ArrowUp') && gameRunning && player.isChargingJump) {
      player.jump();
    }
  });


  function initializeGame() {
    const weight = parseFloat(selectedDinoData.weight);
    player.maxSpeed = 4 + 80 / weight;
    player.jumpPower = -12 - 60 / weight;
    player.gravity = 0.5 * (weight / AVERAGE_WEIGHT);
    player.spriteFrames = spriteCache[selectedDinoData.species];
    gameSpeed = player.maxSpeed / 2;
  }

  function startGame() {
    gameRunning = true;
    score = 0;
    player.lives = 3;
    player.isInvincible = false;
    player.invincibilityTimer = 0;
    player.isChargingJump = false;
    player.jumpCharge = 0;
    obstacles = [];
    player.y = canvas.height - player.height;
    player.isJumping = false;
    if (animationFrameId) cancelAnimationFrame(animationFrameId);
    gameLoop();
  }
    
  function gameLoop() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    handleObstacles();
    player.update();
    player.draw();
    drawHUD();
    drawJumpBar();
    handleCollisions();

    if (!gameRunning) return;

    score++;
    gameFrame++;

    if (score > 0 && score % 250 === 0) {
      gameSpeed += 1.0; 
      player.maxSpeed += 1.0;
    }
    
    if (gameSpeed < player.maxSpeed) {
        gameSpeed += 0.003;
    }

    animationFrameId = requestAnimationFrame(gameLoop);
  }
    
  function handleObstacles() {
    let randomObstacleInterval = Math.max(30, 150 - (score / 25));
    obstacleTimer++;
    if (obstacleTimer > randomObstacleInterval) {
        createObstacle();
        obstacleTimer = 0;
    }
    obstacles.forEach((obstacle, index) => {
        obstacle.update();
        obstacle.draw();
        if (obstacle.x + obstacle.width < 0) obstacles.splice(index, 1);
    });
  }

  function createObstacle() {
    const obstacleHeight = Math.floor(Math.random() * 20) + 20;
    obstacles.push({
      x: canvas.width, y: canvas.height - obstacleHeight, width: 20, height: obstacleHeight,
      draw() {
        ctx.fillStyle = '#FFFFFF'; ctx.beginPath();
        ctx.moveTo(this.x, canvas.height); ctx.lineTo(this.x + this.width / 2, this.y);
        ctx.lineTo(this.x + this.width, canvas.height); ctx.closePath(); ctx.fill();
      },
      update() { this.x -= gameSpeed; }
    });
  }

  function handleCollisions() {
    for (let i = obstacles.length - 1; i >= 0; i--) {
      const obstacle = obstacles[i];
      const hitBoxPadding = 5;
      if (player.x + hitBoxPadding < obstacle.x + obstacle.width &&
          player.x + player.width - hitBoxPadding > obstacle.x &&
          player.y + hitBoxPadding < obstacle.y + obstacle.height &&
          player.y + player.height > obstacle.y) {
        if (!player.isInvincible) {
          hitSound.currentTime = 0;
          hitSound.play();
          player.lives--;
          player.isInvincible = true;
          player.invincibilityTimer = INVINCIBILITY_DURATION;
          obstacles.splice(i, 1);
          if (player.lives <= 0) {
            gameOver();
          }
        }
      }
    }
  }

  function drawHUD() {
    ctx.fillStyle = '#FFFFFF';
    ctx.font = `16px ${GAME_FONT}`;
    ctx.textAlign = 'left';
    ctx.fillText(`Score: ${Math.floor(score)}`, 20, 30);
    if (heartImage.complete) {
        for (let i = 0; i < player.lives; i++) {
            ctx.drawImage(heartImage, 20 + (i * 20), 40, 16, 16);
        }
    }
    ctx.textAlign = 'right';
    ctx.fillText(`High Score: ${Math.floor(highScore)}`, canvas.width - 20, 30);
  }
    
  function drawJumpBar() {
    if (player.isChargingJump) {
        const barX = player.x;
        const barY = player.y - 10;
        const barMaxWidth = player.width;
        const barHeight = 5;
        ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
        ctx.fillRect(barX, barY, barMaxWidth, barHeight);
        ctx.fillStyle = 'rgba(255, 255, 255, 1)';
        ctx.fillRect(barX, barY, barMaxWidth * player.jumpCharge, barHeight);
    }
  }

  function gameOver() {
    gameRunning = false;
    currentMusic.pause();
    currentMusic.currentTime = 0;
    cancelAnimationFrame(animationFrameId);
    if (score > highScore) { 
        highScore = score; 
        localStorage.setItem('dinoRunnerHighScore', Math.floor(highScore)); 
    }
    ctx.fillStyle = 'rgba(0, 0, 0, 0.75)';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = 'white';
    ctx.textAlign = 'center';
    ctx.font = `32px ${GAME_FONT}`;
    ctx.fillText('GAME OVER', canvas.width / 2, canvas.height / 2 - 20);
    ctx.font = `16px ${GAME_FONT}`;
    ctx.fillText(`Tu Puntuacion: ${Math.floor(score)}`, canvas.width / 2, canvas.height / 2 + 20);
    ctx.fillText('Presiona Enter para reiniciar', canvas.width / 2, canvas.height / 2 + 60);
    document.addEventListener('keydown', restartGameListener);
  }

  function restartGameListener(e) {
    if (e.code === 'Enter') {
      document.removeEventListener('keydown', restartGameListener);
      headerElements.forEach(el => el.style.display = 'block');
      dinoSelectorGallery.style.display = 'flex';
      changeMusicBtn.style.display = 'inline-block';
      startBtn.style.display = 'inline-block';
      startBtn.disabled = true;
      dinoSelectorCards.forEach(c => c.classList.remove('selected'));
      initializeScreen();
    }
  }
    
  function initializeScreen() {
    gameContainer.style.display = 'none';
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#FFFFFF';
    ctx.textAlign = 'center';
    ctx.font = `16px ${GAME_FONT}`;
    ctx.fillText("Selecciona un Runner para empezar", canvas.width / 2, canvas.height / 2);
  }

  initializeScreen();
});