<?php

namespace Webbycrown\BlogBagisto\Datagrids;

use Illuminate\Support\Facades\DB;
use Webkul\Core\Models\Channel;
use Webkul\DataGrid\DataGrid;

class CommentDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('blog_comments')
            ->select('blog_comments.id', 'blog_comments.post', 'blog_comments.author', 'blog_comments.email', 'blog_comments.comment', 'blog_comments.status', 'blog_comments.created_at', 'blogs.name as post_name')
            ->leftJoin('blogs', 'blog_comments.post', '=', 'blogs.id');

        return $queryBuilder;
        // $this->setQueryBuilder($queryBuilder);
    }

    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('blog::app.datagrid.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'post_name',
            'label'      => trans('blog::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'comment',
            'label'      => trans('blog::app.datagrid.content'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('blog::app.datagrid.status'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($value) {
                if ($value->status == 1) {
                    return '<span class="badge badge-md badge-warning label-pending">' . trans('blog::app.datagrid.pending') . '</span>';
                } elseif ($value->status == 2) {
                    return '<span class="badge badge-md badge-success label-active">' . trans('blog::app.datagrid.approved') . '</span>';
                } elseif ($value->status == 0) {
                    return '<span class="badge badge-md badge-danger label-canceled">' . trans('blog::app.datagrid.rejected') . '</span>';
                }
            },
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('blog::app.datagrid.published_at'),
            'type'       => 'datetime',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title' => 'edit',
            'method' => 'GET',
            'route' => 'admin.blog.comment.edit',
            'icon' => 'icon-edit',
            'url'    => function ($row) {
                return route('admin.blog.comment.edit', $row->id);
            },
        ]);

        $this->addAction([
            'title' => 'delete',
            'method' => 'POST',
            'route' => 'admin.blog.comment.delete',
            'icon' => 'icon-delete',
            'url'    => function ($row) {
                return route('admin.blog.comment.delete', $row->id);
            },
        ]);
    }

    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'label'  => trans('admin::app.datagrid.delete'),
            'title'  => 'Delete',
            'action' => route('admin.blog.comment.massdelete'),
            'url' => route('admin.blog.comment.massdelete'),
            'method' => 'POST',
        ]);
    }
}