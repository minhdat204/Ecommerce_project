@extends('Admin.Layout.Layout')
@section('namepage', 'Bài Viết')

@section('content')
    <h1>article</h1>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function() {
                if (this.checked) {
                    checkbox.each(function() {
                        this.checked = true;
                    });
                } else {
                    checkbox.each(function() {
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function() {
                if (!this.checked) {
                    $("#selectAll").prop("checked", false);
                }
            });
        });
    </script>
@endpush
