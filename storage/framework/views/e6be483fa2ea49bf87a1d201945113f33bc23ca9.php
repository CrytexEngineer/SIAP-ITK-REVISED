<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SIAP ITK</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <link rel="icon" href="<?php echo e(URL::asset('/css/favicon.png')); ?>" type="image/x-icon"/>
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .button {
                border-radius: 4px;
                background-color: #2164C2;
                border: none;
                color: #FFFFFF;
                text-align: center;
                font-size: 24px;
                padding: 20px;
                width: 200px;
                transition: all 0.5s;
                cursor: pointer;
                margin: 5px;
                box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
            }

            .button span {
                cursor: pointer;
                display: inline-block;
                position: relative;
                transition: 0.5s;
            }

            .button span:after {
                content: '\00bb';
                position: absolute;
                opacity: 0;
                top: 0;
                right: -20px;
                transition: 0.5s;
            }

            .button:hover span {
                padding-right: 25px;
            }

            .button:hover span:after {
                opacity: 1;
                right: 0;
            }

            .nunito { font-family: "Nunito", sans-serif}
        </style>
    </head>
    <body style="
        background: url('<?php echo e(asset('img/landing-page.png')); ?>') no-repeat center fixed;
        background-size: cover;
        ">
        <div class="flex-center position-ref full-height">










            <?php if(Route::has('login')): ?>
            <div class="content">
                <?php if(auth()->guard()->check()): ?>
                    <?php if($role==9): ?>
                        <div class="title m-b-md">
                            <br>
                            <br>
                            <button class="button nunito" onclick="location.href='<?php echo e(url('jadwal_mengajar')); ?>'"><span>Masuk </span></button>
                        </div>
                        <?php else: ?>
                        <div class="title m-b-md">
                            <br>
                            <br>
                            <button class="button nunito" onclick="location.href='<?php echo e(url('/rekapitulasi/mahasiswa')); ?>'"><span>Masuk </span></button>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                <div class="title m-b-md">
                    <br>
                    <br>
                    <button class="button nunito" onclick="location.href='<?php echo e(url('login')); ?>'"><span>Login </span></button>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </body>
</html>
<?php /**PATH D:\Arsip Tugas\FINAL ASSIGMENT\SIAP_ITK\resources\views/welcome.blade.php ENDPATH**/ ?>