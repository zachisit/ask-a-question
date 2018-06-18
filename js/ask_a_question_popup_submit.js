/**
 * File ask_a_question_popup.js
 *
 * global Ask A Question popup
 *
 * 1. trigger popup to show
 * 2. trigger popup to close
 * 3. post form to database via ajax
 *
 * @dependecies: jquery
 * @version: 1.0.0
 * @package ask-a-question-plugin
 */

jQuery(document).ready(function($) {
    var $askButton = $('.ask_a_question'),
        $askPopup = $('#ask_a_question_popup'),
        $popupOverlay = $('#overlay'),
        $closePopupButton = $('.closeAskPopup');

    /*
    1. trigger popup to show
     */
    $askButton.click(function(e){
        $popupOverlay.show();
        $askPopup.show();

        /*
        2. trigger popup to close
         */
        $closePopupButton.click(function(e){
            $popupOverlay.hide();
            $askPopup.hide();
        })
    })

    /*
    3. post form to database via ajax
     */
    var $formSubmitButton = $('#a_p_n_ask_a_question_form_submit'),
        $spinner = $('#spinning_dialog');

    $formSubmitButton.click(function(e) {
        e.preventDefault();

        var $submitQuestionForm = $('#a_p_n_ask_a_question_form'),
            formSubmissionFeedback = $('.h_r_t_s_formSubmissionMessage'),
            submit = true;

        //@TODO:finish error checking
        $submitQuestionForm.find('input').each(function(){
            switch(this.type) {
                case 'radio':
                    var hasSelection = false;
                    //if something with same name has selection
                    //if empty
                    $('input[name='+this.name+']').each(function() {
                        //console.log($(this).is(':checked'))
                        if ($(this).is(':checked')) {
                            hasSelection = true;
                        }
                    });
                    if (!hasSelection) {
                        formSubmissionFeedback[0].classList.add('error');
                        formSubmissionFeedback[0].innerText = this.name+' is empty';
                        submit = false;
                    }
                    break;
                case 'checkbox':
                    formSubmissionFeedback[0].classList.add('error');
                    formSubmissionFeedback[0].innerText = this.name+' is empty';
                    submit = false;

                    break;
                case 'text':
                case 'hidden':
                    submit = true;

                    break;
                default:
                    if ($(this).val() === '') {
                        formSubmissionFeedback[0].classList.add('error');
                        formSubmissionFeedback[0].innerText = this.name+' is empty';
                        submit = false;
                    }
                    break;
            }
        });

        if (submit) {
            var p = formToObject($submitQuestionForm);

            $spinner.css('display','inline-block');
            return postDataToDatabase(p,formSubmissionFeedback);
        }
    });


    /**
     * Form to Object
     *
     * @param formData
     * @returns {{}}
     */
    function formToObject(formData) {
        var p = {};

        $.each($(formData).serializeArray(),function(i, e){
            p[e.name] = e.value;
        });

        //console.log(p);
        return p;
    }

    /**
     * Post Data
     *
     * @param dataArray
     */
    function postDataToDatabase(dataArray,successDiv) {
        console.log(dataArray);
        $.ajax({
            type:'POST',
            async: true,
            url:ajax.url,
            data: dataArray,
            dataType: 'json' //return type
            // success:function(data){
            //     console.log(data);
            // },
            // error: function(errorThrown){
            //     console.log(errorThrown);
            // }
        })
            .success(function(response) {
                $spinner.css('display','none');
                console.log('ajax success call',response);
                if (response === 0) {
                    successDiv.addClass('success');
                    successDiv.html('<i class="fa fa-angellist" aria-hidden="true"></i> Question Submitted! Reloading page now...');
                    console.log(response);
                    setTimeout(function(){
                        //window.location.replace('/hydroponic-research/grow-notes/#technical_support');
                        location.reload();
                    } , 2400);
                } else {
                    successDiv.addClass('fail');
                    successDiv.html('Error: '+status);
                    console.log(response);
                }
            })
            // .fail(function(r,status,jqXHR) {
            //     var formSubmissionFeedback = document.getElementsByClassName('h_r_t_s_formSubmissionMessage');
            //
            //     formSubmissionFeedback[0].classList.add('error');
            //     formSubmissionFeedback[0].innerText = 'Error: '+status;
            //     console.log(status);
            // })
            //     .done(function(r,status,jqXHR) {
            //         var formSubmissionFeedback = document.getElementsByClassName('h_r_t_s_formSubmissionMessage');
            //
            //     formSubmissionFeedback[0].classList.add('success');
            //     formSubmissionFeedback[0].innerText = 'Success: Suvey Form Posted';
            //     console.log(status);
            //
            //     window.location.replace('/hydroponic-research/grow-notes/');
            // })
            //     .then(function(response){
            //         console.log(response);
            //         if (response === 0) {
            //             var formSubmissionFeedback = document.getElementsByClassName('h_r_t_s_formSubmissionMessage');
            //             formSubmissionFeedback[0].classList.add('error');
            //             formSubmissionFeedback[0].innerText = 'Error: '+status;
            //             console.log(status);
            //         } else {
            //             var formSubmissionFeedback = document.getElementsByClassName('h_r_t_s_formSubmissionMessage');
            //             formSubmissionFeedback[0].classList.add('success');
            //             formSubmissionFeedback[0].innerText = 'Success: Suvey Form Posted';
            //             console.log(status);
            //         }
            //     })
            .always( function( data,r,status,jqXHR) {
                if(typeof cb === 'function') cb(data);
                //do promise handling

                console.log('always:',data)
                console.log(r,status,jqXHR)
            })
    }
});