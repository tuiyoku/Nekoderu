<?php
/**
 * Copyright 2010 - 2015, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2015, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<div class="users row">
    <div class="large-6 small-6 columns">
        
        <?php //if (!empty($user->avatar)): ?>
            <!--<h3><?= $this->Html->image(empty($user->avatar) ? $avatarPlaceholder : $user->avatar, ['width' => '180', 'height' => '180']); ?></h3>-->
            <div class="ma spaced-big" style="width: 180px;">
                <input type="hidden" class="tapatar">
            </div>
        <?php //endif; ?>
       
    <?php //@todo add to config ?>
    </div>

    <div class="large-6 small-6 columns">
         <h3 class="user-name">
            <?=
            $this->Html->tag(
                'span',
                __d('CakeDC/Users', '{0} {1}', $user->last_name, $user->first_name),
                ['class' => 'full_name']
            )
            ?>
        </h3>
        <p><a href="/profiles/user/<?= h($user->username) ?>" >@<?= h($user->username) ?></a></p>
        
        <!--<h6 class="subheader"><?= __d('CakeDC/Users', 'Username') ?></h6>-->
        <!--<p><?= h($user->username) ?></p>-->
        <!--<h6 class="subheader"><?= __d('CakeDC/Users', 'Email') ?></h6>-->
        <!--<p><?= h($user->email) ?></p>-->
        <?php if (!empty($user->social_accounts)): ?>
            <h6 class="subheader"><?= __d('CakeDC/Users', 'Social Accounts') ?></h6>
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= __d('CakeDC/Users', 'Avatar'); ?></th>
                        <th><?= __d('CakeDC/Users', 'Provider'); ?></th>
                        <th><?= __d('CakeDC/Users', 'Link'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($user->social_accounts as $socialAccount):
                    $escapedUsername = h($socialAccount->username);
                    $linkText = empty($escapedUsername) ? __d('CakeDC/Users', 'Link to {0}', h($socialAccount->provider)) : h($socialAccount->username)
                    ?>
                    <tr>
                        <td><?=
                            $this->Html->image(
                                $socialAccount->avatar,
                                ['width' => '90', 'height' => '90']
                            ) ?>
                        </td>
                        <td><?= h($socialAccount->provider) ?></td>
                        <td><?=
                            $this->Html->link(
                                $linkText,
                                $socialAccount->link,
                                ['target' => '_blank']
                            ) ?>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
                </tbody>
            </table>
        <?php
        endif;
        ?>
        <?php if (!empty($auth) && $auth['id'] === $user['id']): ?>
        <p>
            <?= $this->Html->link(__('ユーザ情報変更'), ['controller' => 'Profiles', 'action' => 'edit'], ['class' => 'btn btn-default']); ?>
        </p>
        <p>
            <?= $this->Html->link(__('目標確認'), ['controller' => 'Profiles', 'action' => 'archivements',0], ['class' => 'btn btn-default']); ?>
        </p>
        <?php endif; ?>
    </div>
</div>
<!--<h3 class="subheader"><?= __('Your cats') ?></h3>-->
<div style="height:2em;"></div>
<?= $this->element('partial/cats_grid'); ?>

<script async src="/tapatar/exif.js"></script>
<script async src="/tapatar/megapix-image.js"></script>
<script async src="/tapatar/tapatar.js"></script>
<link rel="stylesheet" href="/tapatar/tapatar.css">
<script>
$(window).on('load', function(){
    $('input.tapatar').tapatar({
        image_url_prefix: '/tapatar/img/',
        sources: {
        }
    });
    // $('input.tapatar').on('tapatar.source.picked', function(e, s){
    //     console.log(s);
    // });
    // $('input.tapatar').on('tapatar.source.image_data.set', function(e, s){
    //     console.log("e2");
    // });
    <?php if (!empty($auth) && $auth['id'] === $user['id']): ?>
    <?php else: ?>
        $('.tptr-widget-pick').remove();
    <?php endif; ?>
    
    $('input.tapatar').on('tapatar.source.image_data.save', function(e, s){
        $.post({                                                              
            url: '/profiles/uploadAvatar.json',                   
            data: {data: s}
        }).done(function(data) {
            console.log(data);
            console.log("avatar upload done");
        });       
    });
    $('.tptr-widget').css('background-image', 'url(<?= $avatar['url'] ? $avatar['url']: "/tapatar/img/default.svg" ?>)');
});
</script>
<style type="text/css">
    .tptr-save {
        padding: 0;
        margin-bottom: 0;
    }
    .tptr-source-pick{
        padding:0;
        margin:0;
    }
    .tptr-picker{
        margin-top:30% !important;
    }
    .user-name {
        margin-bottom: 0;
    }
    
    
</style>
