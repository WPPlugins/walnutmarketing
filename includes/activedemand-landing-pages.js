/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function(){
    var $landing=jQuery('#is-activedemand-landing');
    var $lp_id=jQuery('select#activedemand-landing-id');
    
    function set_landing(){
        var $post=jQuery('#postdivrich');
        var $content=jQuery('#post-body-content');
        var iframe_id='ad-landing-frame';
        var $fusion_builder=jQuery('#fusion-pb-switch-button');
        
                
        if($landing.prop('checked')){
            $post.hide();
            $fusion_builder.hide();
            $lp_id.show();
            data={
                action: 'get_landing_html',
                ad_landing_nonce: jQuery('#ad-landing-nonce').val(),
                page: jQuery('#post_ID').val(),
                activedemand_landing_id: jQuery('#activedemand-landing-id').val()
            }
            jQuery.ajax({
                url:adAjax.ajax_url,
                type:'POST',
                data:data,
                dataType: 'text',
                success:function(response){
                    var html=response;
                    $content.append('<iframe id="'+iframe_id+'" class="ad-landing-frame" style="width:100%;height:750px;"></iframe>');
                    var iframe_body=document.getElementById(iframe_id).contentWindow.document;
                    iframe_body.open();
                    iframe_body.write(html);
                    iframe_body.close();
                },
                error: function(response){
                    console.log(response);
                }
            });
            
        } else{
            $post.show();
            $fusion_builder.show();
            $lp_id.hide();
            jQuery('#'+iframe_id).remove();
        }
    }
    
    $landing.on('change',set_landing);
    
    $lp_id.on('change',set_landing);
        
    set_landing();
});