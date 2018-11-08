<?php
if (isset($_REQUEST['id']) && $_REQUEST['a'] == 88) {
    $id = (int)$_REQUEST['id'];
    $uid = $modx->getLoginUserID('web');
    if (isset($_REQUEST['auth'])) {
        include_once (MODX_BASE_PATH . 'assets/lib/MODxAPI/modUsers.php');
        $user = new modUsers($modx);
        if ($_REQUEST['auth']) {
            if (!$uid) {
                $user->authUser($id);
                $uid = $user->getID();
            }
            $auth = 0;
            $actionName = 'Выйти';
        } elseif ($_REQUEST['auth'] == 0) {
            $user->logOut();
            $uid = 0;
        }
    }
    $auth = $uid == $id ? 0 : 1;
    $actionName = $uid == $id ? 'Выйти' : 'Авторизовать';
    $output = <<< OUT
<script type="text/javascript">
(function(){
document.addEventListener('DOMContentLoaded', function() {
    var menu = document.querySelector('div#actions>.btn-group');
    var authBtn = document.createElement('a');
    authBtn.innerHTML = '<i class="fa fa-user-circle" style="display:inline-block;"></i> {$actionName}';
    authBtn.href = 'index.php?a=88&id={$id}&auth={$auth}';
    authBtn.title = '{$actionName}';
    authBtn.className='btn btn-secondary';
    menu.appendChild(authBtn);
    })
}());
</script>
<!-- /managerNav -->
OUT;
    $modx->event->output($output);
}
