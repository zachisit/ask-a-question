<?php
/**
 * Ask-A-Question Form Template
 *
 * @package asset-protection-news
 */
?>
<form method="post" action="" id="a_p_n_ask_a_question_form">
    <div class="row">
        <label for="a_a_q_email">Your Email</label>
        <input type="email" id="a_a_q_email" name="a_a_q_email" value="" maxlength="99" placeholder="example@domain.com"/>
    </div>
    <div class="row">
        <label for="a_a_q_question">Describe your question in detail below</label>
        <textarea id="a_a_q_question" name="a_a_q_question" maxlength="999"></textarea>
    </div>

    <input type="hidden" name="action" value="a_p_n_ask_a_question_form"/>
    <input type="submit" value="submit" id="a_p_n_ask_a_question_form_submit" class="button"/>

    <div class="row">
        <div id="spinning_dialog"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div><div class="a_p_n_ask_a_question_formSubmissionMessage"><!-- --></div>
    </div>
</form>