$(document).ready(function(){

    (function($) {
        "use strict";


    jQuery.validator.addMethod('answercheck', function (value, element) {
        return this.optional(element) || /^\bcat\b$/.test(value)
    }, "type the correct answer -_-");

    // validate contactForm form
    $(function() {
        $('#contactForm').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                subject: {
                    required: true,
                    minlength: 4
                },
                number: {
                    required: true,
                    minlength: 5
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    minlength: 20
                }
            },
            messages: {
                name: {
                    required: "Bon eh bien dans ce cas on vous appellera John Doe, je suis sûr que ce nom vous va à merveille",
                    minlength: "Votre nom doit faire plus de 2 caractère"
                },
                subject: {
                    required: "Un mail sans objet c'est comme un film sans titre",
                    minlength: "Ton objet doit faire au moins 4 caratères"
                },
                number: {
                    required: "T'as raison de pas donner ton numéro, ça aurait pu être une technique de drague. Mais bon bien trop beauf pour que je le fasse bien sûr...",
                    minlength: "Ton numéro doit contenir au moins 5 chiffres"
                },
                email: {
                    required: "Pas d'adresse pas de... Voilà t'as la ref"
                },
                message: {
                    required: "Ton message est aussi rempli d'air qu'un paquet de chips.... D'ailleurs tu savais que c'était pour mieux les conserver? Je veux dire les chips...",
                    minlength: "Quoi c'est tout? :("
                }
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    type:"POST",
                    data: $(form).serialize(),
                    url:"contact_process.php",
                    success: function() {
                        $('#contactForm :input').attr('disabled', 'disabled');
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $(this).find(':input').attr('disabled', 'disabled');
                            $(this).find('label').css('cursor','default');
                            $('#success').fadeIn()
                            $('.modal').modal('hide');
		                	$('#success').modal('show');
                        })
                    },
                    error: function() {
                        $('#contactForm').fadeTo( "slow", 1, function() {
                            $('#error').fadeIn()
                            $('.modal').modal('hide');
		                	$('#error').modal('show');
                        })
                    }
                })
            }
        })
    })

 })(jQuery)
})
