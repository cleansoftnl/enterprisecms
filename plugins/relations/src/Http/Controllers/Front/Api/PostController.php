<?php namespace WebEd\Modules\Relations\Http\Controllers\Front\Api;

use Illuminate\Http\Request;
use WebEd\Base\Http\Controllers\BaseApiController;
use WebEd\Modules\Relations\Repositories\Contracts\RelationsRepositoryContract;
use WebEd\Modules\Relations\Repositories\RelationsRepository;

class PostController extends BaseApiController
{
    protected $module = 'webed-relations';

    /**
     * @var RelationRepository
     */
    protected $repository;

    public function __construct(RelationsRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $result = $this->repository->paginate(2)
            ->setCurrentPaged($this->request->get('page', 1))
            ->with('author')
            ->with('categories')
            ->get();
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->repository->find($id);
        return response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = $this->repository->find($id);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result = $this->repository->find($id);
        return response()->json($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->repository->find($id);
        return response()->json($result);
    }
}
