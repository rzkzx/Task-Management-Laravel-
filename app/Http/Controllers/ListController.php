<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\Response;
use App\Models\Board;
use App\Models\BoardList;

use App\Http\Requests\BoardList\ListStoreRequest;
use App\Http\Requests\BoardList\ListUpdateRequest;

class ListController extends Controller
{
    private $board;
    private $boardList;

    public function __construct(Board $board,BoardList $boardList){
        $this->boardList = $boardList;
        $this->board = $board;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(ListStoreRequest $request, $id)
    {
        $params = $request->only(['name']);

        //checking board
        $find = $this->board->find($id);
        if(!$find){
            return Response::success('board not found');
        }

        //count board for order
        $count = $this->boardList->where('board_id',$id)->get()->count();

        //create board list
        $this->boardList->create([
            'board_id' => $id,
            'order' => $count + 1,
            'name' => $params['name'],
        ]);
        
        return Response::success('create list success');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(ListUpdateRequest $request, $id, $listId)
    {
        $params = $request->only(['name']);

        //checking board
        $findBoard = $this->board->find($id);
        if(!$findBoard){
            return Response::success('board not found');
        }

        $boardList = $this->boardList->where('board_id',$id)->find($listId);
        if(!$boardList){
            return Response::success('list not found');
        }

        $boardList->update($params);

        return Response::success('update list success');
    }

    public function destroy($id,$listId)
    {
        //checking board
        $findBoard = $this->board->find($id);
        if(!$findBoard){
            return Response::success('board not found');
        }

        $data = $this->boardList->where('board_id',$id)->find($listId);
        if(!$data){
            return Response::success('list not found');
        }

        $data->delete();

        return Response::success('delete list success');
    }

    public function moveRight($id,$listId){
        //checking board
        $findBoard = $this->board->find($id);
        if(!$findBoard){
            return Response::success('board not found');
        }

        //checking list
        $list1 = $this->boardList->where('board_id',$id)->find($listId);
        if(!$list1){
            return Response::success('list not found');
        }
        
        //find list order
        $findList = $list1['order']+1;
        $countList = $this->boardList->where('board_id',$id)->count();
        if($findList > $countList){
            return Response::success('cannot move');
        }

        $list2 = $this->boardList->where('board_id',$id)->where('order', '=',$findList)->first();
        
        //trade value order
        $order1 = $list2['order'];
        $order2 = $list1['order'];

        //update order
        $list1->update([
            'order' => $order1
        ]);
        $list2->update([
            'order' => $order2
        ]);

        return Response::success('move success');
    }

    public function moveLeft($id, $listId){
        //checking board
        $findBoard = $this->board->find($id);
        if(!$findBoard){
            return Response::success('board not found');
        }

        //checking list
        $list1 = $this->boardList->where('board_id',$id)->find($listId);
        if(!$list1){
            return Response::success('list not found');
        }
        
        //find list order
        $findList = $list1['order']-1;
        if($findList < 1){
            return Response::success('cannot move');
        }

        $list2 = $this->boardList->where('board_id',$id)->where('order', '=',$findList)->first();
        
        //trade value order
        $order1 = $list2['order'];
        $order2 = $list1['order'];

        //update order
        $list1->update([
            'order' => $order1
        ]);
        $list2->update([
            'order' => $order2
        ]);

        return Response::success('move success');
    }
}
