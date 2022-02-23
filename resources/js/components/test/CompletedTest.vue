<template>
    <div class="complete-container">
        <span class="complete-text confetti">Поздравляем! Квест завершён!</span>
    </div>
</template>

<script>
    export default {
        name: 'CompletedTest',
        methods: {
            generateConfetti: function () {
                $.each($(".complete-text.confetti"), function(){
                    var confettiCount = ($(this).width()/50)*10;
                    for(var i = 0; i <= confettiCount; i++) {
                        $(this).append('<span class="particle c' + $.rnd(1,2) + '" style="top:' + $.rnd(10,50) + '%; left:' + $.rnd(0,100) + '%;width:' + $.rnd(6,8) + 'px; height:' + $.rnd(3,4) + 'px;animation-delay: ' + ($.rnd(0,30)/10) + 's;"></span>');
                    }
                });
            },
            generateCoordinates: function () {
                jQuery.rnd = function(m,n) {
                    m = parseInt(m);
                    n = parseInt(n);
                    return Math.floor( Math.random() * (n - m + 1) ) + m;
                }
            }
        },
        mounted: function () {
            this.generateCoordinates();
            this.generateConfetti();
        },
    }


</script>

<style>
    .complete-container {
        padding: 40px 0;
        text-align: center;
        background: linear-gradient(120deg, #8ec5fc 0%, #8ec5fc 50%, #e0c3fc 100%);
        overflow: hidden;
    }
    .complete-text {
        text-align: center;
        font-size: 40px;
        position: relative;
        color: rgb(255, 255, 255);
        display: block;
        animation: congratulation 1.5s;
        animation-duration: 1.5s;
    }
    .complete-text.confetti > .particle {
        opacity: 0;
        position: absolute;
        -webkit-animation: confetti 3s ease-in infinite;
        animation: confetti 3s ease-in infinite;
    }
    .complete-text.confetti > .particle.c1 {
        background-color: rgba(217, 195, 252, 1);
    }
    .complete-text.confetti > .particle.c2 {
        background-color: rgb(255, 241, 241);
    }

    @-webkit-keyframes confetti {
        0% {
            opacity: 0;
            -webkit-transform: translateY(0%) rotate(0deg);
            transform: translateY(0%) rotate(0deg);
        }
        10% {
            opacity: 1;
        }
        35% {
            -webkit-transform: translateY(-800%) rotate(270deg);
            transform: translateY(-800%) rotate(270deg);
        }
        80% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            -webkit-transform: translateY(2000%) rotate(1440deg);
            transform: translateY(2000%) rotate(1440deg);
        }
    }

    @keyframes confetti {
        0% {
            opacity: 0;
            -webkit-transform: translateY(0%) rotate(0deg);
            transform: translateY(0%) rotate(0deg);
        }
        10% {
            opacity: 1;
        }
        35% {
            -webkit-transform: translateY(-800%) rotate(270deg);
            transform: translateY(-800%) rotate(270deg);
        }
        80% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            -webkit-transform: translateY(2000%) rotate(1440deg);
            transform: translateY(2000%) rotate(1440deg);
        }
    }

    @keyframes congratulation {
        from {left:-100%;}
        to {left:0;}
    }

</style>
