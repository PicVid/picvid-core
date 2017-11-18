<div class="bg-overlay"></div>
<a class="credits d-none d-md-inline-block" href="https://unsplash.com/@clarissemeyer?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Clarisse Meyer">
    <span><i class="fa fa-camera" aria-hidden="true"></i></span>
    <span>Clarisse Meyer</span>
</a>
<div class="container-fluid d-flex flex-column">
    <div class="d-flex flex-row justify-content-start align-items-center p-5 mb-5">
        <a href="{{URL}}">
            <img class="logo" height="65" src="{{LOGO_URL}}"/>
        </a>
    </div>
    <div class="d-flex flex-row justify-content-around align-items-center mt-5 p-5 h-50">
        <div class="col col-4">
            <h2>Willkommen bei PicVid</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean purus felis, semper vitae dui in,
            facilisis imperdiet erat. Morbi elit erat, interdum non nisl at, efficitur condimentum augue. Vestibulum
            vel pellentesque magna. Mauris suscipit accumsan urna, in imperdiet nisi. Cras varius venenatis justo, vel
            mattis neque laoreet vel. Nullam a lorem vitae nunc finibus cursus. Orci varius natoque penatibus et magnis
            dis parturient montes, nascetur ridiculus mus. Sed ut nisl in nunc dignissim placerat.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean purus felis, semper vitae dui in,
            facilisis imperdiet erat. Morbi elit erat, interdum non nisl at, efficitur condimentum augue. Vestibulum
            vel pellentesque magna. Mauris suscipit accumsan urna, in imperdiet nisi. Cras varius venenatis justo, vel
            mattis neque laoreet vel. Nullam a lorem vitae nunc finibus cursus. Orci varius natoque penatibus et magnis
            dis parturient montes, nascetur ridiculus mus. Sed ut nisl in nunc dignissim placerat.</p>
        </div>
        <div class="col col-3">
            <form class="ajax" method="post" data-action="{{URL}}register/register">
                <input type="hidden" name="token" value="{{token}}"/>
                <div class="alert" role="alert"></div>
                <div class="form-group">
                    <label class="sr-only">Username:</label>
                    <input class="form-control" name="register_username" type="text" placeholder="Username"/>
                </div>
                <div class="form-group">
                    <label class="sr-only">E-Mail:</label>
                    <input class="form-control" name="register_email" type="text" placeholder="E-Mail"/>
                </div>
                <div class="form-group">
                    <label class="sr-only">Password:</label>
                    <input class="form-control" name="register_password" type="password" placeholder="Password"/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Register"/>
                </div>
            </form>
        </div>
    </div>
</div>