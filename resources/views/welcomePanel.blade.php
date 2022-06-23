<div class="bg-white rounded-top shadow-sm mb-3">

    <div class="row g-0">
        <div class="col col-lg-7 mt-6 p-4 pe-md-0">

            <h2 class="mt-2 text-dark fw-light">
                Bonjour, ravi de vous voir!
            </h2>

            <p>
                C'est une application fascinante, et c'est assez facile à utiliser.<br>
                Faite d'elle votre outil d'aide au supervision et suivi des demades. Appréciez !
            </p>
        </div>
        <div class="d-none d-lg-block col align-self-center text-end text-muted p-4">
            {{-- <x-orchid-icon path="orchid" width="6em" height="100%"/> --}}
            <img src="/logo.png"  width="25%" height="100%">
        </div>
    </div>

    <div class="row bg-light m-0 p-4 border-top rounded-bottom">

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="rocket"/>

                <span class="ms-3 text-dark">Initier une nouvelle demande</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
               Etes-vous d'habilité à faire une demande? Vous pouvez utiliser le lien ci-dessous pour vous orienter au formulaire afin de
                <a href="{{ route('platform.demande.create') }}" target="_blank" class="text-u-l"> soumettre votre demande</a>.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="book-open"/>

                <span class="ms-3 text-dark">Affichez la liste de vos demandes</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                Aviez-vous déjà soumis une ou plusieurs demandes dans le passé, cliquez simplement <a class="text-u-l" href="{{ route('platform.demandes.list') }}">ICI</a> afin d'afficher la liste de vos demandes.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="monitor"/>

                <span class="ms-3 text-dark">Les graphiques</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                RQ-F fourni une vision large et pronde aux autorités sur l'ensembe des processus grace aux graphiques très intuitives afin de facilité la prise de décision.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="layers"/>

                <span class="ms-3 text-dark">Taitement des demandes</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                Toute demande soumis sera classée pour ainsi initier son processus de traitement auprès des autorités compétentes.
            </p>
        </div>

        <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="star"/>

                <span class="ms-3 text-dark">Notifications</span>
            </h3>
            <p class="ms-md-5 ps-md-1">
                RQ-F dispose d'un système de notification plutôt nécessaire qui se charge de notifier chaque parsonne consernée sur le chaiminement d'une demande.
            </p>
        </div>

        {{-- <div class="col-md-6 my-2">
            <h3 class="text-muted fw-light">
                <x-orchid-icon path="help"/>

                <span class="ms-3 text-dark">Community</span>
            </h3>
            <div class="ms-md-5 ps-md-1">
                <p>Stay up to date on the development of Laravel Orchid and reach out to the community with these
                    helpful
                    resources.</p>
                <ul class="ps-4 m-0">
                    <li>Follow <a href="https://twitter.com/orchid_platform" class="text-u-l">@orchid_platform on
                            Twitter</a>.
                    </li>
                    <li>Join <a href="https://t.me/orchid_community" class="text-u-l">the official Telegram group</a>.
                    </li>
                </ul>
            </div>
        </div> --}}
    </div>

</div>

