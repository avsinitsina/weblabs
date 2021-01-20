$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    get_page();
    init_filter();
});

function init_filter(){
    $('#filter').on('submit', function(e){
        e.preventDefault();
        $(this).data('filter', JSON.stringify($(this).serializeArray()));
        get_page();
    })
}

function deleteRec(id) {
    $.post("/delete/" + id);
    get_page();
}

function load_list(result){
    pgr = $('.pager').html(result.pager);
    $.each(pgr.find('a'), function(i, item){
        number = ($(item).attr('href')).toString().split('=')[1];
        $(item).attr('href', '/list/'+number);
    });
    pgr.find('a').one('click', function(e){
        e.preventDefault();
        get_page($(this).attr('href'));
    });
    $.each(pgr.find('.hidden'), function(i, item){
        $(item).removeClass('hidden').addClass('inline');
    });
    $.each(pgr.find('nav div div'), function(i, item){
        $(item).addClass('inline');
    });
    stylize(pgr);
    $('table.rappers tbody').html("");
    result.rappers.forEach(function(item){
        str = `<tr>
                <td>${item.name}</td>
                <td>${item.genre}</td>
                <td>${item.label}</td>
                <td>${item.country}</td>
                <td>${item.from}</td>
                <td>${item.dead_baddy}</td>
                <td>${item.cool_moves_count}</td>
                <td>${item.swearing_frequency}</td>
                <td><button type='button' id="${item.id}">Delete</button></td>
                <td><a role='button' class=$("btn btn-warning") href="/edit/${item.id}">Edit</a></td>
<!--                onclick="deleteRec(${item.id})"-->
            </tr>`
        $('table.rappers tbody').append(str)
    })
    $('table.rappers tbody').find('button').each(function(i, item) {
        $(item).click(function (){
            deleteRec($(this).attr('id'));
        });
    })
    stylizeTable();
}

function get_page(page = '/list/1'){
    $.post(page,{filter: $('#filter').data('filter')}, function(result){
        load_list(result);
    });
}
function stylize(element){
    element.find('a').addClass("page-link");
    element.find('li').addClass("page-item");
}

function stylizeTable() {
    $('table.rappers tbody').find('a').addClass("btn btn-warning");
    $('table.rappers tbody').find('button').addClass("btn btn-warning");
}
