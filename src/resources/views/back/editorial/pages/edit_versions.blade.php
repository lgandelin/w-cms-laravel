<!-- VERSIONS -->
<div class="tab-pane" id="versions">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Numéro</th>
                    <th>Modification date</th>
                    <th>State</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach ($versions as $version)
                <tr>
                    <td>{{ $version->ID }}</td>
                    <td>{{ $version->number }}</td>
                    <td>{{ $version->updatedDate }}</td>
                    <td style="vertical-align: middle">
                        @if ($page->versionID == $version->ID)
                            <span class="label label-success">Published</span>
                        @elseif ($page->draftVersionID == $version->ID)
                            <span class="label label-info">Draft</span>
                        @endif
                    </td>
                    <td>
                        @if ($page->versionID != $version->ID)
                            <a class="btn btn-primary" target="_blank" href="{{ route('front_page_index_preview', ['uri' => $page->uri, 'version_number' => $version->ID]) }}" title="">{{ trans('w-cms-laravel::generic.preview') }}</a>
                            <a class="btn btn-success" href="{{ route('back_pages_publish_page_version', ['page_id' => $page->ID, 'version_number' => $version->ID]) }}" title="">{{ trans('w-cms-laravel::generic.publish') }}</a>
                            <a class="btn btn-danger" href="{{ route('back_pages_delete_page_version', ['page_id' => $page->ID, 'version_number' => $version->ID]) }}" title="">{{ trans('w-cms-laravel::generic.delete') }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<!-- VERSIONS -->