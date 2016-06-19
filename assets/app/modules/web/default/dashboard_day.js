$(function(){



    _coordinate_width = 220;
    var flow=[];
    for(var i=0;i<7;i++){
        flow.push(Math.floor(Math.random()*(10+((i%16)*5)))+10);
    }

    var data = [
        {
            name : '元',
            value:flow,
            color:'#ec4646',
            line_width:2
        }
    ];

    //计算过去7日
    var now = new Date();
    var day = 60 * 60 * 24 * 1000;
    var now_ts = now.getTime();
    var labels = [];
    for(var i = 1; i < 8; i ++){
        labels[labels.length] = new Date(now_ts - day * (8 - i)).getDate() + '日';
    }

    var chart = new iChart.LineBasic2D({
        render : 'canvasDiv',
        data: data,
        align:'center',
        title : {
            text:'过去7天营收图表',
            font : '微软雅黑',
            fontsize:15,
            color:'#b4b4b4'
        },
        /*subtitle : {
            text:'14:00-16:00访问量达到最大值',
            font : '微软雅黑',
            color:'#b4b4b4'
        },*/
        footnote : {
            text:'鑫业传媒',
            font : '微软雅黑',
            fontsize:11,
            fontweight:600,
            padding:'0 28',
            color:'#b4b4b4'
        },
        width : 330,
        height : 230,
        shadow:true,
        shadow_color : '#202020',
        shadow_blur : 8,
        shadow_offsetx : 0,
        shadow_offsety : 0,
        background_color:'#2e2e2e',
        animation : true,//开启过渡动画
        animation_duration:600,//600ms完成动画
        tip:{
            enable:true,
            shadow:true,
            listeners:{
                //tip:提示框对象、name:数据名称、value:数据值、text:当前文本、i:数据点的索引
                parseText:function(tip,name,value,text,i){
                    return "<span style='color:#005268;font-size:12px;'>"+labels[i]+":00访问量约:<br/>"+
                        "</span><span style='color:#005268;font-size:20px;'>"+value+"万</span>";
                }
            }
        },
        crosshair:{
            enable:true,
            line_color:'#ec4646'
        },
        sub_option : {
            smooth : true,
            label:false,
            hollow:false,
            hollow_inside:false,
            point_size:8
        },
        coordinate:{
            width: _coordinate_width,
            height:260,
            striped_factor : 0.18,
            grid_color:'#4e4e4e',
            axis:{
                color:'#252525',
                width:[0,0,4,4]
            },
            scale:[{
                position:'left',
                start_scale:0,
                end_scale:100,
                scale_space:10,
                scale_size:2,
                scale_enable : false,
                label : {color:'#9d987a',font : '微软雅黑',fontsize:11,fontweight:600},
                scale_color:'#9f9f9f'
            },{
                position:'bottom',
                label : {color:'#9d987a',font : '微软雅黑',fontsize:11,fontweight:600},
                scale_enable : false,
                labels:labels
            }]
        }
    });
    //利用自定义组件构造左侧说明文本
    chart.plugin(new iChart.Custom({
        drawFn:function(){
            //计算位置
            var coo = chart.getCoordinate(),
                x = coo.get('originx'),
                y = coo.get('originy'),
                w = coo.width,
                h = coo.height;
            //在左上侧的位置，渲染一个单位的文字
            chart.target.textAlign('start')
                .textBaseline('bottom')
                .textFont('600 11px 微软雅黑')
                .fillText('单位:元',x-0,y-12,false,'#9d987a')
                .textBaseline('top')
                .fillText('(时间)',x+w+12,y+h+10,false,'#9d987a');

        }
    }));
    //开始画图
    chart.draw();
});

