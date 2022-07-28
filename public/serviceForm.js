function refreshCategoryList(path){
    $(document).on('change','.imputRefresh',function () {
        id = $(this).attr('id');
        boatId = $("#"+id).val();
        companyId = $('#companyId').val();
        data = {
            'boatId' : boatId,
            'companyId': companyId
        }
        $.ajax({
            data:
                {
                    id : id,
                    data : data
                },
            url: path,
            async: true,
            type: 'GET',
            success: function (result) {

                $('#categorySelect').append(result)
            },
        });
    })
}

function refreshTypeCabinList(path){
    $(document).on('change','#cabinCategory',function () {
        id = $(this).attr('id');
        categoryId = $("#"+id).val();

        $.ajax({
            data:
                {
                    id : id,
                    data : categoryId
                },
            url: path,
            async: true,
            type: 'GET',
            success: function (result) {

                $('#cabinTypeSelect').html(result)

            },
        });
    })
}

/**
 *
 * @param path
 */
function showForfaitsByConfig(path){
    $(document).on('change','#cabinTypes',function () {
        id = $(this).attr('id');
        categoryId = $("#"+id).val();

        $.ajax({
            data:
                {
                    id : id,
                    data : categoryId
                },
            url: path,
            async: true,
            type: 'GET',
            success: function (result) {

                $('#cabinTypeSelect').html(result)

            },
        });
    })
}

