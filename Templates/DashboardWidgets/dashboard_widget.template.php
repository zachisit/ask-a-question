<?php
/**
 * Dashboard Widget Template
 *
 * @var $submissions
 * @var $total_count
 * @package ask-a-question-plugin
 */
?>

<p>Total Submissions: <strong><?=($total_count) ? $total_count : 'None yet!'?></strong></p>
<table class="widefat">
    <thead>
        <tr>
            <td>Date</td>
            <td>Question</td>
        </tr>
    </thead>
    <tbody>
    <?php if (isset($submissions)) : ?>
    <?php foreach ($submissions as $entry) : ?>
        <tr>
            <td width="20%"><?=\WPAskAQuestion\Utility::return_calendar_date($entry['submission_time'])?></td>
            <td width="80%"><?=$entry['a_a_q_question']?></td>
        </tr>
    <?php endforeach ?>
    <?php else : ?>
    <tr>
        <td>No Submissions Yet!</td>
    </tr>
    <?php endif ?>
    </tbody>
</table>