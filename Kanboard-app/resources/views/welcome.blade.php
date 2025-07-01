<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

      </head>
      <style>
       
      </style>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <div class="banner">
    @if (Route::has('login'))
        <nav class="auth-links">
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </nav>
    @endif

    <img src="{{ asset('images/banner.png') }}" alt="Bannière">
    <h2 class="banner-text">La gestion de projet, simplifiée en un tableau</h2>
</div>

            <section class="presentation">
                <div class="container">
                    <h2>Gérez vos projets, visuellement et efficacement</h2>
                    <p>
                        Notre plateforme vous permet de créer facilement des tableaux de gestion de projet pour organiser vos tâches, suivre l’avancement, collaborer avec votre équipe et garder une vue claire sur vos objectifs.
                    </p>
                    <p>
                        Que vous soyez entrepreneur, étudiant, freelance ou chef de projet, notre outil vous aide à structurer vos idées et à transformer vos projets en réussites concrètes.
                    </p>
                    <p>
                        Créez votre premier tableau dès maintenant, et passez à l’action.
                    </p>
                    <a href="{{ route('login') }}" class="cta-button">Commencer maintenant</a>
                    </div>
            </section>

            <section class="why-us">
                <div class="container">
                    <h2>Pourquoi choisir notre outil plutôt qu’un autre ?</h2>
                    <div class="features">
                        <div class="feature">
                            <h3>Simplicité d'utilisation</h3>
                            <p>
                                Une interface claire, intuitive et sans prise de tête. Créez et gérez vos projets en quelques clics, sans formation.
                            </p>
                        </div>
                        <div class="feature">
                            <h3>Vue centralisée</h3>
                            <p>
                                Un tableau unique pour avoir une vision globale de vos tâches, de vos priorités et des délais en temps réel.
                            </p>
                        </div>
                        <div class="feature">
                            <h3>Gratuit et sans engagement</h3>
                            <p>
                                Commencez dès maintenant sans carte bancaire. Notre outil est gratuit pour les petites équipes ou projets solo.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="about-us">
                <div class="container">
                    <h2>À propos de nous</h2>
                    <p class="intro">
                        Nous sommes une équipe passionnée par la productivité, la clarté et la collaboration. Notre mission est de rendre la gestion de projet accessible à tous, quels que soient votre expérience ou la taille de votre équipe.
                    </p>
                    <div class="about-grid">
                        <div class="about-block">
                            <h3>Notre vision</h3>
                            <p>
                                Offrir un outil simple, visuel et puissant pour que chacun puisse transformer ses idées en actions concrètes. Nous croyons que tout projet mérite un cadre clair pour avancer efficacement.
                            </p>
                        </div>
                        <div class="about-block">
                            <h3>Notre engagement</h3>
                            <p>
                                Créer une plateforme intuitive, sans complexité inutile, où chaque utilisateur peut gérer ses projets sans effort technique. Nous écoutons notre communauté et évoluons avec elle.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer class="site-footer">
            <div class="footer-container">
                <div class="footer-about">
                    <h3>GestionPro</h3>
                    <p>Un outil simple et visuel pour organiser vos projets, collaborer efficacement et atteindre vos objectifs.</p>
                </div>

                <div class="footer-links">
                    <h4>Liens utiles</h4>
                    <ul>
                        <li><a href="{{ route('login') }}">Connexion</a></li>
                        <li><a href="{{ route('register') }}">Inscription</a></li>
                        <li><a href="#features">Fonctionnalités</a></li>
                        <li><a href="#about">À propos</a></li>
                    </ul>
                </div>

                <div class="footer-contact">
                    <h4>Contact</h4>
                    <p>Email : support@gestionpro.com</p>
                    <p>Adresse : 123 Avenue du Progrès, Paris</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} GestionPro. Tous droits réservés.</p>
            </div>
        </footer>

    </body>
</html>
