<?php

namespace WPAskAQuestion;


class Database
{
    private static $database_name = 'ask_a_question_submissions';

    /**
     * @return string
     */
    protected static function getDatabaseName()
    {
        return self::$database_name;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function insertAskAQuestionSubmission($data)
    {
        global $wpdb;
        $table = $wpdb->prefix . self::getDatabaseName();
        $format = [
            '%s',
            '%s',
            '%s',
            '%s',
        ];
        $success = $wpdb->insert($table, $data, $format);

        return $success;
    }

    /**
     * @return mixed
     */
    public static function return_submission_data()
    {
        global $wpdb;
        $table = $wpdb->prefix . self::getDatabaseName();

        $sql = $wpdb->prepare( "SELECT * FROM {$table} LIMIT 5",$results );
        $results = $wpdb->get_results( $sql, ARRAY_A );

        return $results;
    }

    /**
     * @return mixed
     */
    public static function return_submission_total_count()
    {
        global $wpdb;
        $table = $wpdb->prefix . self::getDatabaseName();

        $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM {$table}");

        return $rowcount;
    }
}