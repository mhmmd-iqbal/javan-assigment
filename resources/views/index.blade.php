<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" integrity="sha512-t4GWSVZO1eC8BM339Xd7Uphw5s17a86tIZIj8qRxhnKub6WoyhnrxeCIMeAqBPgdZGlCcG2PrZjMc+Wr78+5Xg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body class="container pt-5">
        <div class="mb-2">
            <input type="hidden" name="id" value="">
            <input class="" name="name" type="text" placeholder="Nama">
            <select class="" name="gender">
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
            <select class="" name="parent_id"></select>
        
            <button id="action-btn" onclick="createData()">Save</button>
        </div>
        
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Parent</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="list-data"></tbody>
            </table>
        </div>
    </body>
</html>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    function getOptionList() {
        getPeople().then((result) => {
            let optionlist = '<option value="" selected> -- Tidak Ada Parent --</option>'
            $.each(result.data, function (index, data) {
                optionlist += `<option value=${data.id}> ${data.name}</option>`
            });

            $('select[name=parent_id]').html(optionlist)

        }).catch((err) => {
            alert('Gagal mengambil data')
        });
    }

    function getTableList() {
        $('#list-data').empty();
        getPeople().then((result) => {
            $.each(result.data, function (index, data) {
                let htmlList = ''
                htmlList = `<tr>
                        <td>${index + 1}</td>
                        <td>${data.name}</td>
                        <td>${data.gender === 'M' ? 'Male' : 'Female'}</td>
                        <td>${data.parent !== null ? data.parent.name : '-'}</td>
                        <td>
                                <button onclick="deleteData(this)" data-id="${data.id}">Delete</button>
                                <button onclick="updateData(this)"
                                    data-id="${data.id}"
                                    data-name="${data.name}"
                                    data-gender="${data.gender}"
                                    data-parent_id="${data.parent !== null ? data.parent.id : null}">Update</button>
                        </td>
                    </tr>`
                
                $('#list-data').append(htmlList)
            });
        })
    }

    function updateData(e) {
        let {id, name, gender, parent_id} = $(e).data()

        $('input[name=id]').val(id)
        $('input[name=name]').val(name)
        $('select[name=gender]').val(gender)
        $('select[name=parent_id]').val(parent_id)
        $('#action-btn').html('Update')
    }

    function createData() {
        let id = $('input[name=id]').val()
        let name = $('input[name=name]').val()
        let gender = $('select[name=gender]').val()
        let parent_id = $('select[name=parent_id]').val() ?? null

        if (!name || !gender) {
            return alert('name dan gender tidak boleh kosong')
        }

        if (id) {
            updatePeople({id:id, name:name, gender:gender, parent_id:parent_id}).then((result) => {
                alert('Sukses Update data')
                getOptionList()
                getTableList()
                $('input[name=id]').val('')
                $('input[name=name]').val('')
                $('select[name=gender]').val('M')
                $('select[name=parent_id]').val('')
                $('#action-btn').html('Save')
            }).catch((err) => {
                alert('Gagal update data')
            })
        } else {
            storePeople({name:name, gender:gender, parent_id:parent_id}).then((result) => {
                alert('Sukses tambah data')
                getOptionList()
                getTableList()
                $('input[name=id]').val('')
                $('input[name=name]').val('')
                $('select[name=gender]').val('M')
                $('select[name=parent_id]').val('')
                $('#action-btn').html('Save')
            }).catch((err) => {
                alert('Gagal menambah data')
            });
        }
    }

    function deleteData(e) {
        let {id} = $(e).data()

        if (confirm("Lanjutkan hapus data") == true) {
            deletePeople({id: id}).then((result) => {
                alert('Sukses hapus data')
                getOptionList()
                getTableList()
            }).catch((err) => {
                alert('Gagal menghapus data')
            })
        }
    }

    $(document).ready(function () {
        getOptionList()
        getTableList()
    });

    function getPeople() {
        return $.ajax({
            type: "GET",
            url: ""
        });
    }

    function storePeople(params) {
        let {name, gender, parent_id} = params

        return $.ajax({
            type: "POST",
            url: "/store",
            data: {
                "_token": "{{ csrf_token() }}",
                name: name,
                gender: gender,
                parent_id: parent_id
            }
        })
    }

    function updatePeople(params) {
        let {id, name, gender, parent_id} = params
        return $.ajax({
            type: "PUT",
            url: "/update/"+id,
            data: {
                "_token": "{{ csrf_token() }}",
                name: name,
                gender: gender,
                parent_id: parent_id
            }
        })
    }

    function deletePeople({id: id}) {
        return $.ajax({
            type: "DELETE",
            url: "/delete/"+id,
            data: {
                "_token": "{{ csrf_token() }}",
            }
        })
    }

</script>