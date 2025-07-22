<!DOCTYPE html>

<html>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
        rel="stylesheet"
        as="style"
        onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Space+Grotesk%3Awght%40400%3B500%3B700" />

    <title>BoardTech</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>

<body>
    <div class="relative flex size-full min-h-screen flex-col bg-[#151118] dark group/design-root overflow-x-hidden" style='font-family: "Space Grotesk", "Noto Sans", sans-serif;'>
        <div class="layout-container flex h-full grow flex-col">
            <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#322839] px-10 py-3">
                <div class="flex items-center gap-4 text-white">
                    <div class="size-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                    <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">BoardTech</h2>
                </div>
                <div class="flex flex-1 justify-end gap-8">
                    <div class="flex items-center gap-9">
                        @if (Route::has('login'))
                        <button class="auth-links">
                            @auth
                            <a class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#a334f3] text-white text-sm font-bold leading-normal tracking-[0.015em]" href="{{ url('/dashboard') }}">Commencer</a>
                            @else
                            <a class="text-white text-sm font-medium leading-normal"  href="{{ route('login') }}">Log in</a>
                            @if (Route::has('register'))
                            <a class="text-white text-sm font-medium leading-normal"  href="{{ route('register') }}">Register</a>
                            @endif
                            @endauth
                        </nav>
                        @endif
                    </button>
                </div>
            </header>
            <div class="px-40 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
                    <div class="@container">
                        <div class="@[480px]:p-4">
                            <div
                                class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-xl items-center justify-center p-4"
                                style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDFBWGdzthxFRT9o3yKCaOxEUB4fNr9C77y6AAnUMqSFX_i0cqDFAcGQ9Gw1jucBg3-MU65ax4ID2J5ezivhi1B6Ba5_FUgjzji0IYGSk4DvcN8h6s7k8KMBT-G__ooUrRxrm5mj2L_DGyDx-9uCAhDBnZjhYLOyUbWXI68Jw3lzbihItDjNVub4LpZqS5qxe85sZ3aQZVVkjRN69Ll0ZvARmoO7f4NTESq5C7f6bBbfsg02ON14uU24G1_3Xg2kzYD6pRzETHkilw");'>
                                <div class="flex flex-col gap-2 text-center">
                                    <h1
                                        class="text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]">
                                        ProjectFlow : Visualisez Votre Succès
                                    </h1>
                                    <h2 class="text-white text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal">
                                        Transformez votre gestion de projet avec notre tableau Kanban intuitif et notre vue calendrier. Collaborez en toute transparence et suivez les progrès sans
                                        effort.
                                    </h2>
                                </div>
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-[#a334f3] text-white text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em]">
                                    <span class="truncate">Commencer</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-10 px-4 py-10 @container">
                        <div class="flex flex-col gap-4">
                            <h1
                                class="text-white tracking-light text-[32px] font-bold leading-tight @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] max-w-[720px]">
                                Fonctionnalités Clés
                            </h1>
                            <p class="text-white text-base font-normal leading-normal max-w-[720px]">
                                Explorez les fonctionnalités puissantes qui font de ProjectFlow l'outil de gestion de projet ultime.
                            </p>
                        </div>
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3">
                            <div class="flex flex-col gap-3 pb-3">
                                <div
                                    class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD8aorAMe6ebF37cByWp-hvHzMPzkN0J2ecdAYprAglFwpAevHMIT-TU7rtB913oZ0dTRrEXFMpyWSaDrv3Ba0lr154tZ_iJRHtYo1H_q5l_ahVrRx3upOhs-NS7sX_J6QTVwI5nFiwez3U62l4bnEs4kQJJHPFEihH5BERhJTyfbjemTAwR9wS_OrHlOmpVh3VgbCPThTTUOYWMaNqlfKLpxL1wY9zFW6ckZwOB77W0oWx5MFP6Knk3wKB23cqJHG8XCTmeWKBLBE");'></div>
                                <div>
                                    <p class="text-white text-base font-medium leading-normal">Tableau Kanban</p>
                                    <p class="text-[#ad9cba] text-sm font-normal leading-normal">
                                        Visualisez votre flux de travail avec notre tableau Kanban dynamique. Glissez et déposez facilement les tâches pour gérer les progrès.
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div
                                    class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuC3lhEpNb3WeN3sH-mylG3dN7lMqkM_RB0hG5lxzfpzRO6P5e_U1oaWqD5tcU-OCmvgL9U7pm1TUWijpyNj_0rSZjXM1vK2FrcTrt2Dc2Eer4Nn1VPGxy4Q-Ws4FtinH3Cwn71y-fa1vCPsC9SRhqUM_g3Ha_n2DwlMgd8pLoelnoyrCHUQFsbGEKlVwcB1cWLqcAHnOIdxEH4j9PkwZ4Mdvo2PMCTK-0doHC_uupYY_Hx8QuZO7nUlP5h02aZG-lb_ry6ah2CafkQ");'></div>
                                <div>
                                    <p class="text-white text-base font-medium leading-normal">Vue Calendrier</p>
                                    <p class="text-[#ad9cba] text-sm font-normal leading-normal">
                                        Restez au courant des échéances avec notre vue calendrier intégrée. Planifiez et programmez les tâches avec facilité.
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div
                                    class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCGgLCUIKh0msvbgnFnrogGpdu4Z5SH20jjWeXG5USPMHy-31vCJnrhBwDNSVj0MiyaKmKE26ZEyNRBjOOV9b6yqgsHFdNqEgSqqfazftfVBjy9n2juOifpknXO85ozWWlycEwfMoIlB0j1Xv57iM5n-AaFn0yONilw-yDiDmbDdqecbcYFTyZSDt2TfHPOMqSAte6vaLx_mFoG5lZdctoWhIKcnFSXEUzhTilMbHqG9dTOXnhHHTQaxGpCr2dhFDwI8ciAPPb06UM");'></div>
                                <div>
                                    <p class="text-white text-base font-medium leading-normal">Collaboration d'Équipe</p>
                                    <p class="text-[#ad9cba] text-sm font-normal leading-normal">
                                        Collaborez avec votre équipe en temps réel. Partagez des mises à jour, attribuez des tâches et communiquez efficacement.
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3 pb-3">
                                <div
                                    class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBd9palMWdwGgSlqYReh6RaswoRdNfMGpZWwV6ewDKkwPNoLth9tgMeleFbuSlb-QO558K8JHRyS6GDCuGK6QkoUzmTtwftzoqEMtgRKlRvi5zPTgvRnqyYZt3OMNrvhe-z4ycUf4FVjREQ_F2sWuuADclREZyo0hsZ0k6lbU2Of8NbnvcmmCmpsZJjAZRUndO5kG2n7kWudARKciN0LSw6TuuojqkAvspqkfiMel2tVTwh4632PYNG7CPzmc9f6ENnOwmMuSU9t08");'></div>
                                <div>
                                    <p class="text-white text-base font-medium leading-normal">Statistiques de Projet</p>
                                    <p class="text-[#ad9cba] text-sm font-normal leading-normal">
                                        Suivez les performances de votre projet avec des statistiques détaillées. Surveillez les progrès et identifiez les domaines à améliorer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="@container">
                        <div class="flex flex-col justify-end gap-6 px-4 py-10 @[480px]:gap-8 @[480px]:px-10 @[480px]:py-20">
                            <div class="flex flex-col gap-2 text-center">
                                <h1
                                    class="text-white tracking-light text-[32px] font-bold leading-tight @[480px]:text-4xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] max-w-[720px]">
                                    Prêt à Améliorer Votre Gestion de Projet ?
                                </h1>
                                <p class="text-white text-base font-normal leading-normal max-w-[720px">Rejoignez des milliers d'équipes qui réalisent déjà plus avec ProjectFlow.</p>
                            </div>
                            <div class="flex flex-1 justify-center">
                                <div class="flex justify-center">
                                    <button
                                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-[#a334f3] text-white text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em] grow">
                                        <span class="truncate">Démarrez Votre Essai Gratuit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="flex justify-center">
                <div class="flex max-w-[960px] flex-1 flex-col">
                    <footer class="flex flex-col gap-6 px-5 py-10 text-center @container">
                        <div class="flex flex-wrap items-center justify-center gap-6 @[480px]:flex-row @[480px]:justify-around">
                            <a class="text-[#ad9cba] text-base font-normal leading-normal min-w-40" href="#">Conditions d'Utilisation</a>
                            <a class="text-[#ad9cba] text-base font-normal leading-normal min-w-40" href="#">Politique de Confidentialité</a>
                            <a class="text-[#ad9cba] text-base font-normal leading-normal min-w-40" href="#">Nous Contacter</a>
                        </div>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="#">
                                <div class="text-[#ad9cba]" data-icon="TwitterLogo" data-size="24px" data-weight="regular">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                                        <path
                                            d="M247.39,68.94A8,8,0,0,0,240,64H209.57A48.66,48.66,0,0,0,168.1,40a46.91,46.91,0,0,0-33.75,13.7A47.9,47.9,0,0,0,120,88v6.09C79.74,83.47,46.81,50.72,46.46,50.37a8,8,0,0,0-13.65,4.92c-4.31,47.79,9.57,79.77,22,98.18a110.93,110.93,0,0,0,21.88,24.2c-15.23,17.53-39.21,26.74-39.47,26.84a8,8,0,0,0-3.85,11.93c.75,1.12,3.75,5.05,11.08,8.72C53.51,229.7,65.48,232,80,232c70.67,0,129.72-54.42,135.75-124.44l29.91-29.9A8,8,0,0,0,247.39,68.94Zm-45,29.41a8,8,0,0,0-2.32,5.14C196,166.58,143.28,216,80,216c-10.56,0-18-1.4-23.22-3.08,11.51-6.25,27.56-17,37.88-32.48A8,8,0,0,0,92,169.08c-.47-.27-43.91-26.34-44-96,16,13,45.25,33.17,78.67,38.79A8,8,0,0,0,136,104V88a32,32,0,0,1,9.6-22.92A30.94,30.94,0,0,1,167.9,56c12.66.16,24.49,7.88,29.44,19.21A8,8,0,0,0,204.67,80h16Z"></path>
                                    </svg>
                                </div>
                            </a>
                            <a href="#">
                                <div class="text-[#ad9cba]" data-icon="LinkedinLogo" data-size="24px" data-weight="regular">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                                        <path
                                            d="M216,24H40A16,16,0,0,0,24,40V216a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V40A16,16,0,0,0,216,24Zm0,192H40V40H216V216ZM96,112v64a8,8,0,0,1-16,0V112a8,8,0,0,1,16,0Zm88,28v36a8,8,0,0,1-16,0V140a20,20,0,0,0-40,0v36a8,8,0,0,1-16,0V112a8,8,0,0,1,15.79-1.78A36,36,0,0,1,184,140ZM100,84A12,12,0,1,1,88,72,12,12,0,0,1,100,84Z"></path>
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <p class="text-[#ad9cba] text-base font-normal leading-normal">© 2024 ProjectFlow. Tous droits réservés.</p>
                    </footer>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>