var i = 1;

function updateGrid() {
    if (i > lifecycles) {
        return;
    }

    var reqData = {"grid": $('.js-grid pre').html()};
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
});
