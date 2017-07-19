<?php

function activedemand_partial_getHTML($url, $timeout)
{
    $result = "";
    if (in_array('curl', get_loaded_extensions())) {
        $ch = curl_init($url); // initialize curl with given url
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
       // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
        curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);//force IP4
        $result = curl_exec($ch);
        curl_close($ch);
    } elseif (function_exists('file_get_contents')){
        $result = file_get_contents($url);
    }

    return $result;
}

$options = get_option('activedemand_options_field');
$activedemand_appkey = $options["activedemand_appkey"];

if ("" != $activedemand_appkey) {
    //get Forms
    $url = "https://api.activedemand.com/v1/forms.xml?api-key=" . $activedemand_appkey . "";
    $str = activedemand_partial_getHTML($url, 10);
    $form_xml = simplexml_load_string($str);

    //get Blocks
    $url = "https://api.activedemand.com/v1/smart_blocks.xml?api-key=" . $activedemand_appkey . "";
    $str = activedemand_partial_getHTML($url, 10);
    $block_xml = simplexml_load_string($str);
}
?>
<div id="activedemand_editor" class="shortcode_editor" title="Insert Walnut Marketing Shortcode"
     style="display:none;height:500px">
    <?php if (""!=$form_xml) { ?>
        <h3>Available Walnut Marketing Web Forms:</h3>
        <style scoped="scoped" type="text/css">
            div.ad-form-list {
            }

            div.ad-form-list ul li span {
                margin-left: 20px;
                font-size: 1.2em;
                font-weight: bold;
            }
        </style>
        <div class="ad-form-list">
            <ul>
                <?php
                foreach ($form_xml->children() as $child) {
                    echo "<li>";
                    echo "<input type='radio' name='form_id' value='";
                    echo '[activedemand_form id="';
                    echo $child->id;
                    echo '"]';
                    echo "'/>";
                    echo "<span>";
                    echo $child->name;
                    echo "</span>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
    <?php } else { ?>
        <h2>No Web Forms Configured</h2>
        <p>To use the Walnut Marketing web form shortcodes, you will first have to add some web forms to your account in
            Marketing Portal. Once you do have web forms configured, the available shortcodes will be displayed here.</p>
    <?php } ?>
    <br/>
    <?php if ("" != $block_xml) { ?>
        <h3>Available WalnutMarketing Content Blocks:</h3>
        <style scoped="scoped" type="text/css">
            div.ad-form-list {
            }

            div.ad-form-list ul li span {
                margin-left: 20px;
                font-size: 1.2em;
                font-weight: bold;
            }
        </style>
        <div class="ad-form-list">
            <ul>
                <?php
                foreach ($block_xml->children() as $child) {
                    echo "<li>";
                    echo "<input type='radio' name='form_id' value='";
                    echo '[activedemand_block id="';
                    echo $child->id;
                    echo '"]';
                    echo "'/>";
                    echo "<span>";
                    echo $child->name;
                    echo "</span>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
    <?php } else { ?>
        <h2>No Content Blocks Configured</h2>
        <p>To use the ActiveDEMAND Dynamic Content Block shortcodes, you will first have to add content blocks to your account
            in
            ActiveDEMAND. Once you do have content blocks configured, the available shortcodes will be displayed
            here.</p>
    <?php } ?>

</div>