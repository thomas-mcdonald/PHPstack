##PHPstack

PHPstack is an easy to use wrapper for the Stack Exchange API.

    <?php
        require_once('lib/requestcore.class.php');
        require_once('phpstack.class.php');

        $so = new PHPstack('stackoverflow.com', 'yourAPIKey');
        $answer = $so->getAnswers(2921234));
        print_r($answer);
    ?>