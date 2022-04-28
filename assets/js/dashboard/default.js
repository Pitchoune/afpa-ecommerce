// revenue chart
new Chartist.Bar('.revenue-chart', {
    labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'],
    series: [
        [400, 580, 200, 450, 650, 400, null, null, null, null, null],
        [null, null, null, null, null, null, 500, 300, 480, 600, 350]
    ],
}, {
    stackBars: true,
    chartPadding: {
        left: 0
    },
    axisY: {
        labelInterpolationFnc: function(value) {
            return (value / 1000) + 'k';
        },
        showLabel: false,
        showGrid: false,
        offset: 0,
    },
    axisX: {
        showGrid: false,
    }

}).on('draw', function(ctx) {
    if(ctx.type === 'bar') {
        ctx.element.attr({
            x1: ctx.x1 + 0.05,
            style: 'stroke-width: 15px ; stroke-linecap: round'
        });
    }
});


// btn js
$('.btn-js').click(function(){
    //make all inactive-doesn't work
    $( '.btn-js' ).each(function( ) {
        if($(this).hasClass('active')){
            $(this).removeClass('active')
        }
    });

    if($(this).hasClass('active')){
        $(this).removeClass('active')
    } else {
        $(this).addClass('active')
    }
});

$('.btn-js1').click(function(){
    $( '.btn-js1' ).each(function( ) {
        if($(this).hasClass('active')){
            $(this).removeClass('active')
        }
    });

    if($(this).hasClass('active')){
        $(this).removeClass('active')
    } else {
        $(this).addClass('active')
    }
});
