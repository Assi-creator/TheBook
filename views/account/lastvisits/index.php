<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/user/user.php';
$api = new TheBook\controller\User;
$sessions = $api->getAllSessions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Входы в аккаунт</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="main-body page-content">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/editheader.php"; ?>

    <div class="wrapper-ugc" style="max-width: 816px; margin-top: 15px;">
        <div class="block-border card-block">
            <h2 class="group-title">Входы в аккаунт</h2>
            <div class="with-pad form-new">
                <table class="linear-list-compact">
                    <tbody>
                    <tr>
                        <th>IP адрес</th>
                        <th>Время</th>
                        <th>Браузер, система</th>
                    </tr>
                    <?php
                    foreach($sessions as $session):?>
                    <tr class="p unnoticeable">
                        <td style="text-align: center;padding: 5px 0;"><?php echo $session['ip']; ?></td>
                        <td style="text-align: center;padding: 5px 0;"><?php echo formatDate($session['date']); ?></td>
                        <td style="text-align: center;padding: 5px 0;"><?php echo $session['browser']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>

<?php function formatDate($date) {
    $months = array(
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    );
    $parts = explode(' ', $date);
    $dateParts = explode('-', $parts[0]);
    $timeParts = explode(':', $parts[1]);
    $day = (int)$dateParts[2];
    $month = $months[(int)$dateParts[1]-1];
    $hour = $timeParts[0];
    $minutes = $timeParts[1];
    return $day.' '.$month.' '.$hour.':'.$minutes;
}
?>