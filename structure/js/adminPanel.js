$(function () {

    //OPERATIONS ON USERS TABLE

    //event for clicking delete user button
    var delBtnsUser = $('.btnDelUser');

    delBtnsUser.click(function () {

        var btnDelUser = $(this);

        var idUser = btnDelUser.parent().siblings().first().text();
        //ajax for deleting user from database and table
        $.ajax({
            url: './resources/api/adminEditUser.php',
            dataType: 'json',
            data: 'id=' + idUser,
            type: 'DELETE'
        }).always(function () {
            btnDelUser.parent().parent().remove();
            alert('User deleted!');
        });

//         done function doesn't work because json return is invalid
//            }).done(function (success) {
//            if (success) {
//                btnDelUser.parent().parent().remove();
//
//            }
//        }).fail(function () {
//            alert('error');
//        });

    });

    //event for edit button
   // var editUserBtns = $('.btnEditUser');

   // editUserBtns



    //event for clicking delete item button
    var delBtnsItem = $('.btnDelItem');

    delBtnsItem.click(function () {

        var btnDelItem = $(this);

        var idItem = btnDelItem.parent().siblings().first().text();

        var id = "id=" + idItem;
        //ajax for deleting item from database and table
        $.ajax({
            url: 'resources/api/adminEditItem.php',
            dataType: 'json',
            data: id,
            type: 'DELETE'
        }).always(function () {
            btnDelItem.parent().parent().remove();
            alert('Item deleted!');
        });
    });


    //event for clicking delete admin button
    var delBtnsAdmin = $('.btnDelAdmin');

    delBtnsAdmin.click(function () {

        var btnDelAdmin = $(this);

        var idAdmin = btnDelAdmin.parent().siblings().first().text();

        var id = "id=" + idAdmin;
        //ajax for deleting admin from database and table
        $.ajax({
            url: 'resources/api/adminEditAdmin.php',
            dataType: 'json',
            data: id,
            type: 'DELETE'
        }).always(function () {
            btnDelAdmin.parent().parent().remove();
            alert('Admin deleted!');
        });
    });

});





