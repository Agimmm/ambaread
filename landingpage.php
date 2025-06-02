<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmbaRead - Gerbang Ilmu untuk Semua</title>
    <!-- Import Poppins font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif; /* Changed all font to Poppins */
        }
        
        body {
            background-color: #f5f5f5;
            overflow-x: hidden;
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
        }
        
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('assets/background.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -1;
            opacity: 0.6; /* 60% opacity as requested */
        }
        
        .header {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
            animation: fadeIn 1s ease-in-out;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #333;
        }
        
        .logo h1 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }
        
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 20px;
            position: relative;
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            width: 90%;
            max-width: 1200px;
            opacity: 0;
            animation: slideUp 1s ease-in-out forwards;
            position: relative;
            overflow: hidden;
        }
        
        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('assets/opacity.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.25; /* 25% opacity as requested */
            z-index: 0;
        }
        
        .card-content {
            flex: 2;
            position: relative;
            z-index: 2;
        }
        
        .card-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .card-image img {
            max-width: 100%;
            opacity: 0;
            animation: fadeIn 1s ease-in-out 0.5s forwards;
        }
        
        h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #222;
            font-weight: 700;
        }
        
        h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
        }
        
        p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #444;
            font-weight: 400;
        }
        
        .bold-text {
            font-weight: 700; /* Made bold as requested */
        }
        
        .divider {
            width: 80%;
            height: 3px;
            background-color: #000000;
            margin: 20px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 40px;
            background-color: #2c5282;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            opacity: 0;
            animation: fadeIn 1s ease-in-out 1s forwards;
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            background-color: #1a365d;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @media (max-width: 768px) {
            .card {
                flex-direction: column;
                padding: 30px;
            }
            
            .card-image {
                margin-top: 30px;
            }
            
            h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="background"></div>
    
   <?php include 'header.php'; ?>
    
    <main class="main-content">
        <div class="card">
            <div class="card-content">
                <h2>Selamat Datang di AmbaRead!</h2>
                
                <h3>Gerbang Ilmu untuk Semua, Kapan Saja dan di Mana Saja!</h3>
                <p><span class="bold-text">Literasi adalah jendela dunia.</span><br>
                Kami hadir untuk membukakan jendela itu lebih lebar.</p>
                
                <div class="divider"></div>
                
                <p>Di tengah derasnya arus informasi, membaca adalah kekuatan.<br>
                Di sinilah tempatnya—ruang baca digital yang bisa diakses semua orang, dari anak-anak hingga orang tua, tanpa batasan waktu dan tempat.</p>
                
                <a href="login.php" class="btn" id="getStartedBtn">Get Started</a>
            </div>
            <div class="card-image">
                <img src="assets/anakanak.png" alt="Reader with headphones">
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const getStartedBtn = document.getElementById('getStartedBtn');
            
            // Add hover animation
            getStartedBtn.addEventListener('mouseover', function() {
                this.style.transform = 'scale(1.05)';
            });
            
            getStartedBtn.addEventListener('mouseout', function() {
                this.style.transform = 'scale(1)';
            });
            
            // Add click animation
            getStartedBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add a pulse effect
                this.style.transform = 'scale(0.95)';
                
                // Create ripple effect
                const ripple = document.createElement('div');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
                ripple.style.width = '20px';
                ripple.style.height = '20px';
                ripple.style.transform = 'translate(-50%, -50%)';
                ripple.style.animation = 'ripple 0.6s linear';
                
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                // Redirect after animation
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 600);
            });
            
            // Add ripple animation to style
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    0% {
                        width: 0;
                        height: 0;
                        opacity: 0.5;
                    }
                    100% {
                        width: 500px;
                        height: 500px;
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>