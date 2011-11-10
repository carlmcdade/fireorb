<?php
$output = fo_1_text('
      <h1 class="title">Welcome to your new FireOrb website!</h1>
      <p>This notice is showing because you have not yet created any first page content for your website. You can change this page by editing
      the "start.php" file in the root directory of your FireOrb installation. Please follow these steps to set up and start using your website:</p>
      <ol>
        <li>
          <strong>Create your administrator account</strong>
          To begin, <a href="%register">create the first account</a>.This account will have full administration rights and will allow you to configure your website.
        </li>
        <li>
          <strong>Configure your website</strong>
          Once logged in, visit the <a href="%admin">administration section</a>, where you can <a href="%config">customize and configure</a> all aspects of your website.
        </li>
        <li>
          <strong>Enable additional functionality</strong>
          Next, visit the <a href="%modules">module list</a> and enable features which suit your specific needs. You can find additional modules in the <a href="%download_modules">FireOrb modules download section</a>.
        </li>
        <li>
          <strong>Customize your website design</strong>
          To change the "look and feel" of your website, visit the <a href="%themes">themes section</a>. You may choose from one of the included themes or download additional themes from the <a href="%download_themes">FireOrb themes download section</a>.
        </li>
        <li>
          <strong>Start posting content</strong>
          Finally, you can <a href="%content">create content</a> for your website. This message will disappear once you have published your first post.
        </li>
      </ol>
      <p>For more information, please refer to the <a href="%help">Help section</a>, or the <a href="%handbook">online FireOrb handbooks</a>. You may also post at the <a href="%forum">FireOrb forum</a>, or view the wide range of <a href="%support">other support options</a> available.</p>',
      array('%fireorb' => 'http://fireorb.info/', '%register' => fo_1_url('user/register'), '%admin' => fo_1_url('admin'), '%config' => fo_1_url('admin/settings'), '%modules' => fo_1_url('admin/modules'), '%download_modules' => 'http://modules.fireorb.info', '%themes' => fo_1_url('admin/themes'), '%download_themes' => 'http://themes.fireorb.info', '%content' => fo_1_url('node/add'), '%help' => fo_1_url('admin/help'), '%handbook' => 'http://docs.fireorb.info', '%forum' => 'http://forum.fireorb.info', '%support' => 'http://support.fireorb.info')
    );
    $output = '<div id="first-time">'. $output .'</div>';
    
    ?>
