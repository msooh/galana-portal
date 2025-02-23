<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Virtual Suggestion Box</title>

        <link href="{{ asset('css/suggestions.css') }}" rel="stylesheet">

    </head>
    <body>       
        <div class="container slider-one-active">
            <div class="steps">
            <div class="step step-one">
                <div class="liner"></div>
                <span>Hello!</span>
            </div>
            <div class="step step-two">
                <div class="liner"></div>
                <span>Rating</span>
            </div>
            <div class="step step-three">
                <div class="liner"></div>
                <span>Conclusion</span>
            </div>
            </div>
            <div class="line">
            <div class="dot-move"></div>
            <div class="dot zero"></div>
            <div class="dot center"></div>
            <div class="dot full"></div>
            </div>
            <div class="slider-ctr">
            <div class="slider">
                <form class="slider-form slider-one">
                <h2>Step Form Design Experience</h2>
                <label class="input">
                    <input type="text" class="name" placeholder="What's your name?">
                </label>
                <button class="first next">Next Step</button>
                </form>
                <form class="slider-form slider-two">
                <h2>Are you happy with our service?</h2>
                <div class="label-ctr">
                    <label class="radio">
                    <input type="radio" value="happy" name="condition">
                    <div class="emot happy">
                        <div class="mouth sad"></div>
                    </div>
                    </label>
                    <label class="radio">
                    <input type="radio" value="happy" name="condition">
                    <div class="emot happy">
                        <div class="mouth smile"></div>
                    </div>
                    </label>
                </div>
                <button class="second next">Next Step</button>
                </form>
                <div class="slider-form slider-three">
                <h2>Hello, <span class="yourname"></span></h2>
                <h3>Thank you for your input!
                            </h3>
                <a class="reset" href="https://codepen.io/balapa/pen/XbXVRg" target="_blank">Reset</a>
                </div>
            </div>
            </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/suggestion.js') }}"></script>
    </body>
</html>
