<a class="credits d-none d-md-inline-block" href="https://unsplash.com/@clarissemeyer?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Clarisse Meyer">
    <span><i class="fas fa-camera" aria-hidden="true"></i></span>
    <span>Clarisse Meyer</span>
</a>
<div class="container-fluid d-flex flex-column">
    <div class="d-flex flex-row justify-content-center justify-content-sm-center justify-content-md-start justify-content-lg-start justify-content-xl-start p-5">
        <a href="{{URL}}"><img class="logo" height="65" src="{{LOGO_URL}}"/></a>
    </div>
    <div class="row d-flex flex-row mt-1 mt-md-3 mx-0 justify-content-center">
        <div class="col col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5 pr-md-5 mb-4 mb-sm-4 mb-md-4 mb-lg-0 mb-xl-0">
            <h2>Willkommen bei PicVid</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean purus felis, semper vitae dui in,
            facilisis imperdiet erat. Morbi elit erat, interdum non nisl at, efficitur condimentum augue. Vestibulum
            vel pellentesque magna. Mauris suscipit accumsan urna, in imperdiet nisi. Cras varius venenatis justo, vel
            mattis neque laoreet vel. Nullam a lorem vitae nunc finibus cursus. Orci varius natoque penatibus et magnis
            dis parturient montes, nascetur ridiculus mus. Sed ut nisl in nunc dignissim placerat.</p>
        </div>
        <div class="col col-12 col-sm-12 col-md-6 col-lg-5 col-xl-4 pl-md-5 mb-2">
            <form class="ajax" method="post" data-action="{{URL}}register/register">
                <input type="hidden" name="token" value="{{token}}"/>
                <div class="alert" role="alert"></div>
                <div class="form-group">
                    <label class="sr-only" for="username">Benutzername:</label>
                    <input class="form-control" id="username" name="register_username" autocomplete="username" type="text" placeholder="Benutzername"/>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="email">E-Mail:</label>
                    <input class="form-control" id="email" name="register_email" autocomplete="email" type="text" placeholder="E-Mail"/>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="password">Passwort:</label>
                    <input class="form-control" id="password" name="register_password" autocomplete="new-password" type="password" placeholder="Passwort"/>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-sm-block"><i class="fas fa-sign-in-alt" aria-hidden="true"></i>Registrieren</button>
                </div>
            </form>
        </div>
    </div>
</div>