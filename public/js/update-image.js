var i = 1;
var glider = false;
var stop = false;

function updateGrid() {
    if (i > lifecycles) {
        return;
    }

    var reqData = {};
    reqData['grid'] = $('.js-grid pre').html();
    if(glider) {
        reqData['glider'] = true;
        glider = false;
    }

    if(stop) {
        return;
    }
    
    return $.ajax({
        cache: false,
        url: '/game/update-grid',
        method: 'POST',
        data: JSON.stringify(reqData),
        dataType: "json"
    }).then(function (response) {
        console.log(response.grid);
        $('.js-grid pre').html(response.grid);
    }).then(function () {
        i++;
        setTimeout(function(){
            return updateGrid();
        }, 50);
    });
}

$(document).ready(function () {
    if (lifecycles) {
        updateGrid();
    }

    $('button[name=glider]').on('click', function() {
        glider = true;
    });

    $('button[name=stop]').on('click', function() {
        stop = true;
    });
});
