<?php
/** 
 * Authorisation script.
 * This contains universal headers and some utility functions, but not BODY.
 * Scripts including this file should implement their own content.
 *
 * @author  Andrew Jeffries
 *
 * @version         1.0.0           prototype
 */

if (session_status() == PHP_SESSION_NONE)
    session_start();

require_once 'includes/dbutils.php';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-us">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <title>Feed The Hungry Mildura</title>
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
               <script type='text/javascript'>//<![CDATA[
            $(window).load(function(){
                var $j = jQuery.noConflict();
                $j('.reviewtekst').each(function(){
                    var $pTag = $j(this).find('p');
                    if($pTag.text().length > 300){
                        var shortText = $pTag.text();
                        shortText = shortText.substring(0, 300);
                        $pTag.addClass('fullArticle').hide();
                        $pTag.append('<a class="read-less-link">Read Less</a>');
                        $j(this).append('<p class="preview">'+shortText+'</p><div class="curtain-shadow"></div><a class="read-more-link">Read more</a>');
                    }
                });
                $j(document).on('click', '.read-more-link', function (){
                    $j(this).hide().parent().find('.preview').hide().prev().show();
                });
                $j(document).on('click', '.read-less-link', function (){
                    $j(this).parent().hide().next().show();
                    $j(this).parents('.reviewtekst').find('.read-more-link').show();
                });
            });//]]> 
        </script>
    </head>
<?php
/** 
 * Converts ISO8601 dates to ENDIAN dates (Oz style, leading figure is DAYS).
 *
 * @param       string          $datChange              Date in ISO8601 format.
 * @return      string                                  Date in endian format.
 */
function datChange($datChange)
{
    return date('d/m/Y',strtotime($datChange));
}

?>
