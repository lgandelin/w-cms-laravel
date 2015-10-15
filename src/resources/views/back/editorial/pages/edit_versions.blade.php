<!-- VERSIONS -->
<div class="tab-pane" id="versions">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Version date</th>
                    <th>State</th>
                    <th>Action</th>
                </tr>
            </thead>
            @for ($i = 1; $i <= $page->draft_version_number; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ date('d/m/Y H:i') }}</td>
                    <td style="vertical-align: middle">
                        @if ($page->version_number == $i)
                            <span class="label label-success">Published</span>
                        @elseif ($page->draft_version_number == $i)
                            <span class="label label-info">Draft</span>
                        @endif
                    </td>
                    <td>
                        @if ($page->version_number != $i)
                            <a class="btn btn-primary" target="_blank" href="{{ route('front_page_index_preview', ['uri' => $page->uri, 'version_number' => $i]) }}" title="">{{ trans('w-cms-laravel::generic.preview') }}</a>
                            <a class="btn btn-success" href="{{ route('back_pages_publish_page_version', ['page_id' => $page->ID, 'version_number' => $i]) }}" title="">{{ trans('w-cms-laravel::generic.publish') }}</a>
                            <a class="btn btn-danger" href="{{ route('back_pages_delete_page_version', ['page_id' => $page->ID, 'version_number' => $i]) }}" title="">{{ trans('w-cms-laravel::generic.delete') }}</a>
                        @endif
                    </td>
                </tr>
            @endfor
        </table>
    </div>
</div>
<!-- VERSIONS -->