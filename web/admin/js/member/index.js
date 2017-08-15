;
var member_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $(".block").click( function(){
            that.ops( "block",$(this).attr("data-id") )
        });

        $(".recover").click( function(){
            that.ops( "recover",$(this).attr("data-id") )
        });

        $(".delete").click( function(){
            that.ops( "delete",$(this).attr("data-id") )
        });
    },
    ops:function( act,id ){
        var callback = {
            'ok':function(){
                $.ajax({
                    url:common_ops.buildAdminUrl("/member/ops"),
                    type:'POST',
                    data:{
                        act:act,
                        id:id
                    },
                    dataType:'json',
                    success:function( res ){
                        var callback = null;
                        if( res.code == 200 ){
                            callback = function(){
                                window.location.href = window.location.href;
                            }
                        }
                        common_ops.alert( res.msg,callback );
                    }
                });
            },
            'cancel':null
        };
        var msg;
        if(act == "block") msg="确定锁定？";
        else if(act == "recover") msg = "确定恢复？";
        else if(act == "delete") msg = "确认删除？";
        common_ops.confirm( msg,callback );
    }
};

$(document).ready( function(){
    member_index_ops.init();
});