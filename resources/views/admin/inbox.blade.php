@extends('mainlayout')

@section('container')
<div class="mt-20">
    <h3> Forum Admin </h3>
    <div class="row">
        <div class="col-12">
            <table class="table email-table no-wrap table-hover v-middle mb-0 font-14">
                <tbody>
                    <tr>
                        <td class="pl-3">
                            <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input"
                                    id="cst1"> <label class="custom-control-label" for="cst1">&nbsp;</label></div>
                        </td>
                        <td> <a class="link" href="javascript: void(0)"> <span class="badge badge-pill text-white font-medium badge-danger mr-2">Comment</span> <span
                            class="text-dark">There is a new post in your topic -</span> </a></td>
                        <td><i class="fa fa-paperclip text-muted"></i></td>
                        <td class="text-muted">May 13</td>
                    </tr>
                    <tr>
                        <td class="pl-3">
                            <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input"
                                    id="cst1"> <label class="custom-control-label" for="cst1">&nbsp;</label></div>
                        </td>
                        <td> <a class="link" href="javascript: void(0)"> <span class="badge badge-pill text-white font-medium badge-danger mr-2">Comment</span> <span
                            class="text-dark">There is a new post in your topic -</span> </a></td>
                        <td><i class="fa fa-paperclip text-muted"></i></td>
                        <td class="text-muted">May 13</td>
                    </tr>
                    <tr>
                        <td class="pl-3">
                            <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input"
                                    id="cst1"> <label class="custom-control-label" for="cst1">&nbsp;</label></div>
                        </td>
                        <td> <a class="link" href="javascript: void(0)"> <span class="badge badge-pill text-white font-medium badge-danger mr-2">Comment</span> <span
                            class="text-dark">There is a new post in your topic -</span> </a></td>
                        <td><i class="fa fa-paperclip text-muted"></i></td>
                        <td class="text-muted">May 13</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection