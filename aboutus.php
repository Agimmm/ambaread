<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Team Showcase</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #0f172a;
            color: #f8fafc;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        header {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }
        
        .header-content {
            z-index: 10;
        }
        
        h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #6366f1, #2dd4bf);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards 0.5s;
        }
        
        .subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards 0.7s;
        }
        
        .scroll-btn {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            font-size: 2rem;
            color: #f8fafc;
            animation: bounce 2s infinite;
            cursor: pointer;
            opacity: 0;
            animation: bounce 2s infinite 1.5s, fadeIn 1s ease forwards 1.5s;
        }
        
        section {
            padding: 6rem 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .about {
            background-color: #1e293b;
        }
        
        .about-content {
            opacity: 0;
            transform: translateY(50px);
            transition: all 1s ease;
        }
        
        .about-content.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(to right, #6366f1, #2dd4bf);
        }
        
        p {
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .team {
            background-color: #0f172a;
        }
        
        .team-title {
            text-align: center;
            margin-bottom: 4rem;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .team-title.visible {
            opacity: 1;
            transform: translateY(0);
            transition: all 1s ease;
        }
        
        .team-members {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }
        
        .member {
            background-color: #1e293b;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transform: translateY(50px);
            opacity: 0;
            transition: all 0.5s ease;
        }
        
        .member.visible {
            transform: translateY(0);
            opacity: 1;
        }
        
        .member-img {
            height: 400px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .member-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background-color: #2a3649;
            padding: 10px;
            transition: transform 0.5s;
        }
        
        .member:hover .member-img img {
            transform: scale(1.1);
        }
        
        .member-info {
            padding: 1.5rem;
        }
        
        .member h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .member-role {
            color: #94a3b8;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .social-links a {
            color: #f8fafc;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .social-links a:hover {
            color: #6366f1;
        }
        
        .contact {
            background-color: #1e293b;
            text-align: center;
        }
        
        .contact-title {
            margin-bottom: 3rem;
            opacity: 0;
        }
        
        .contact-title.visible {
            opacity: 1;
            transition: opacity 1s ease;
        }
        
        .contact-info {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 3rem;
            margin-bottom: 3rem;
        }
        
        .contact-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .contact-item.visible {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.5s ease;
        }
        
        .contact-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #6366f1;
        }
        
        footer {
            background-color: #0f172a;
            padding: 2rem 0;
            text-align: center;
        }
        
        .footer-content {
            opacity: 0;
        }
        
        .footer-content.visible {
            opacity: 1;
            transition: opacity 1s ease;
        }
        
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            40% {
                transform: translateX(-50%) translateY(-20px);
            }
            60% {
                transform: translateX(-50%) translateY(-10px);
            }
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }
            
            .subtitle {
                font-size: 1.2rem;
            }
            
            .team-members {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
</head>
<body>
    
    <header id="home">
        <div id="particles-js" class="particles"></div>
        <div class="header-content">
            <h1>Creative Team Showcase</h1>
            <p class="subtitle">AmbaRead Team Showcase</p>
        </div>
        <div class="scroll-btn" id="scrollBtn">&#8595;</div>
    </header>
    
    <section class="about" id="about">
        <div class="container">
            <div class="about-content">
                <h2>About AmbaRead</h2>
                <p>Welcome to our Creative Team Showcase! This website highlights the exceptional talent within our team. We're a group of dedicated professionals passionate about creating innovative solutions and delivering outstanding results.</p>
                <p>Our team consists of creatives from various backgrounds, each bringing unique skills and perspectives to the table. Through collaboration and mutual respect, we tackle challenging projects and continuously push the boundaries of what's possible.</p>
                <p>This showcase features detailed profiles of our team members, providing insight into their expertise, experience, and creative approach. Whether you're looking to collaborate with us or simply interested in learning more about our team, we invite you to explore our profiles and get to know us better.</p>
            </div>
        </div>
    </section>
    
    <section class="team" id="team">
        <div class="container">
            <div class="team-title">
                <h2>Our Team</h2>
            </div>
            <div class="team-members">
                <div class="member" data-delay="0.2">
                    <div class="member-img">
                        <img src="assets/agim.png" alt="Amir Gymnastiar">
                    </div>
                    <div class="member-info">
                        <h3>Amir Gymnastiar</h3>
                        <div class="member-role">Undergraduate Student of Information System Universitas Airlangga</div>
                        <p>Amir Gymnastiar adalah mahasiswa Universitas Airlangga yang aktif dalam bidang teknologi dan memiliki latar belakang pendidikan di Pondok Pesantren sebelum melanjutkan studi di UNAIR. Ia dikenal sebagai penggiat teknologi dan pernah menulis tentang isu sosial seperti kesenjangan sosial di Indonesia. Selain itu, Amir juga tercatat sebagai peserta program Magang dan Studi Independen Bersertifikat (MSIB) Kampus Merdeka, yang menunjukkan keterlibatannya dalam pengembangan kompetensi praktis di luar perkuliahan.</p>
                        <div class="social-links">
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i> Twitter</a>
                            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i> LinkedIn</a>
                        </div>
                    </div>
                </div>
                
                <div class="member" data-delay="0.4">
                    <div class="member-img">
                        <img src="assets/jaki.png" alt="Dzaky Muttaqi Sunaryadi">
                    </div>
                    <div class="member-info">
                        <h3>Dzaky Muttaqi Sunaryadi</h3>
                        <div class="member-role">Undergraduate Student of Information System Universitas Airlangga</div>
                        <p>Dzaky Muttaqi Sunaryadi adalah mahasiswa Universitas Airlangga (UNAIR) Surabaya yang aktif mengikuti berbagai kegiatan kampus, termasuk Field Study sebagai anggota Kelompok 8 dengan NIM 187231075, serta tercatat dalam acara Octavoir FST '23 di Fakultas Sains dan Teknologi UNAIR. Ia berlokasi di Surabaya dan namanya kerap muncul dalam dokumentasi kegiatan kampus di media sosial resmi UNAIR seperti YouTube dan Instagram.</p>
                        <div class="social-links">
                            <a href="#" aria-label="GitHub"><i class="fab fa-github"></i> GitHub</a>
                            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin"></i> LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="contact" id="contact">
        <div class="container">
            <div class="contact-title">
                <h2>Get In Touch</h2>
            </div>
            <div class="contact-info">
                <div class="contact-item" data-delay="0.2">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>contact@creativeteam.com</p>
                </div>
                
                <div class="contact-item" data-delay="0.4">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Phone</h3>
                    <p>+1 (555) 123-4567</p>
                </div>
                
                <div class="contact-item" data-delay="0.6">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Location</h3>
                    <p>123 Creative Avenue, Design District</p>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2025 Creative Team Showcase. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        // Particles.js configuration
        particlesJS('particles-js', {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#6366f1'
                },
                shape: {
                    type: 'circle',
                    stroke: {
                        width: 0,
                        color: '#000000'
                    },
                    polygon: {
                        nb_sides: 5
                    }
                },
                opacity: {
                    value: 0.5,
                    random: false,
                    anim: {
                        enable: false,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 3,
                    random: true,
                    anim: {
                        enable: false,
                        speed: 40,
                        size_min: 0.1,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#6366f1',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200
                    }
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'grab'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    },
                    resize: true
                },
                modes: {
                    grab: {
                        distance: 140,
                        line_linked: {
                            opacity: 1
                        }
                    },
                    bubble: {
                        distance: 400,
                        size: 40,
                        duration: 2,
                        opacity: 8,
                        speed: 3
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.4
                    },
                    push: {
                        particles_nb: 4
                    },
                    remove: {
                        particles_nb: 2
                    }
                }
            },
            retina_detect: true
        });
        
        // Smooth scrolling
        document.getElementById('scrollBtn').addEventListener('click', function() {
            document.querySelector('#about').scrollIntoView({ 
                behavior: 'smooth' 
            });
        });
        
        // Scroll animations
        const observerOptions = {
            threshold: 0.25,
            rootMargin: '0px'
        };
        
        const observer = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('about-content')) {
                        entry.target.classList.add('visible');
                    } else if (entry.target.classList.contains('team-title')) {
                        entry.target.classList.add('visible');
                        animateTeamMembers();
                    } else if (entry.target.classList.contains('contact-title')) {
                        entry.target.classList.add('visible');
                        animateContactItems();
                    } else if (entry.target.classList.contains('footer-content')) {
                        entry.target.classList.add('visible');
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        observer.observe(document.querySelector('.about-content'));
        observer.observe(document.querySelector('.team-title'));
        observer.observe(document.querySelector('.contact-title'));
        observer.observe(document.querySelector('.footer-content'));
        
        function animateTeamMembers() {
            const members = document.querySelectorAll('.member');
            members.forEach((member, index) => {
                setTimeout(() => {
                    member.classList.add('visible');
                }, parseFloat(member.dataset.delay) * 1000);
            });
        }
        
        function animateContactItems() {
            const items = document.querySelectorAll('.contact-item');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('visible');
                }, parseFloat(item.dataset.delay) * 1000);
            });
        }
        
        // Typed.js effect simulation
        const titles = ["AmbaRead", "Meet Our Professionals", "Introduction"];
        let titleIndex = 0;
        const titleElement = document.querySelector('h1');
        
        setInterval(() => {
            titleElement.style.opacity = 0;
            
            setTimeout(() => {
                titleIndex = (titleIndex + 1) % titles.length;
                titleElement.textContent = titles[titleIndex];
                titleElement.style.opacity = 1;
            }, 500);
        }, 3000);
        
        // Parallax effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            const scrollPosition = window.pageYOffset;
            
            if (scrollPosition < header.offsetHeight) {
                document.querySelector('#particles-js').style.transform = `translateY(${scrollPosition * 0.5}px)`;
            }
        });
        
        // Hover effect for team members
        const teamMembers = document.querySelectorAll('.member');
        teamMembers.forEach(member => {
            member.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
                this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.4)';
            });
            
            member.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.3)';
            });
        });
    </script>
</body>
</html>