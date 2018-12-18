<table id="orgnization" class="table table-bordered table-striped ">
    <thead>
        <tr>
            <th>Name</th>
            <th>Countrie</th>
            <th></th>
        </tr>
    </thead>
</table>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function (f) {
    // this function for access data table pages using url
        var hashPageNum = window.location.hash.replace('#', '');
        if (hashPageNum == '') {
            hashPageNum = 1;
        }
        hashPageNum = (hashPageNum - 1) * 10;
        table = $('#orgnization').DataTable({
            "ordering": false,
            "bLengthChange": false,
            "processing": true,
            "serverSide": true,
            "displayStart": hashPageNum,
            "fnDrawCallback": function (oSettings) {
                var pageCount = oSettings._iDisplayStart / oSettings._iDisplayLength;
                pageCount = Number(pageCount) + Number(1)
                window.location.hash = '#' + pageCount;
            },
            "order": [],
            "lengthMenu": [
                [10],
                [10]
            ],
            "ajax": {
                "url": "{!! url('link/dataTable') !!}",
                "type": "POST",
                'beforeSend': function (request) {
                    request.setRequestHeader("X-CSRF-TOKEN", window._token);
                }
            },
        });
    });
</script>
