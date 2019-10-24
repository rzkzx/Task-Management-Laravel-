<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\Response;
use App\Models\Card;
use App\Models\BoardList;
use App\Models\Board;

use App\Http\Requests\Card\CardStoreRequest;
use App\Http\Requests\Card\CardUpdateRequest;

class CardController extends Controller
{
    private $card;
    private $boardList;
    private $board;

    public function __construct(Card $card, BoardList $boardList, Board $board){
        $this->card = $card;
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

    public function store(CardStoreRequest $request, $id, $listId)
    {
        $params = $request->only(['task']);

        //checking board
        $findBoard = $this->board->find($id);
        if(!$findBoard){
            return Response::success('board not found');
        }

        //checking list in board
        $findList = $this->boardList->where('board_id',$findBoard['id'])->find($listId);
        if(!$findList){
            return Response::success('list not found');
        }

        //count card order
        $countOrder = $this->card->where('list_id',$findList['id'])->count();

        //create card
        $this->card->create([
            'list_id' => $findList['id'],
            'order' => $countOrder+1,
            'task' => $params['task']
        ]);

        return Response::success('create card success');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(CardUpdateRequest $request, $id, $listId, $cardId)
    {
        $params = $request->only(['task']);

        //checking board
        $findBoard = $this->board->find($id);
        if(!$findBoard){
            return Response::success('board not found');
        }

        //checking list in board
        $findList = $this->boardList->where('board_id',$findBoard['id'])->find($listId);
        if(!$findList){
            return Response::success('list not found');
        }

        //checking card
        $card = $this->card->where('list_id',$findList['id'])->find($cardId);
        if(!$card){
            return Response::success('card not found');
        }

        //update card
        $card->update($params);

        return Response::success('update card success');
    }

    public function destroy($id, $listId, $cardId)
    {
        //checking board
        $findBoard = $this->board->find($id);
        if(!$findBoard){
            return Response::success('board not found');
        }

        //checking list in board
        $findList = $this->boardList->where('board_id',$findBoard['id'])->find($listId);
        if(!$findList){
            return Response::success('list not found');
        }

        //checking card
        $card = $this->card->where('list_id',$findList['id'])->find($cardId);
        if(!$card){
            return Response::success('card not found');
        }

        $card->delete();

        return Response::success('delete card success');
    }

    public function moveUp($boardId, $listId, $cardId){
        //checking board
        $findBoard = $this->board->find($boardId);
        if(!$findBoard){
            return Response::success('board not found');
        }

        //checking list in board
        $findList = $this->boardList->where('board_id', $findBoard['id'])->find($listId);
        if(!$findList){
            return Response::success('list not found');
        }


        $card = $this->card->where('list_id',$findList['id'])->find($cardId);
        if(!$card){
            return Response::success('card not found');
        }

        if($card['order'] <= 1){
            return Response::success('cannot move');
        }

        $tradeCard = $this->card->where('list_id',$findList['id'])->where('order',$card['order']-1)->first();

        $orderUp = $tradeCard['order'];
        $orderDown = $card['order'];

        $card->update([
            'order' => $orderUp
        ]);
        $tradeCard->update([
            'order' => $orderDown
        ]);

        return Response::success('move success');

    }

    public function moveDown($boardId, $listId, $cardId){
        //checking board
        $findBoard = $this->board->find($boardId);
        if(!$findBoard){
            return Response::success('board not found');
        }

        //checking list in board
        $findList = $this->boardList->where('board_id', $findBoard['id'])->find($listId);
        if(!$findList){
            return Response::success('list not found');
        }

        $card = $this->card->where('list_id',$findList['id'])->find($cardId);
        if(!$card){
            return Response::success('card not found');
        }

        $countCard = $this->card->where('list_id', $findList['id'])->count();

        if($card['order'] >= $countCard){
            return Response::success('cannot move');
        }

        $tradeCard = $this->card->where('list_id', $findList['id'])->where('order',$card['order']+1)->first();

        $orderUp = $tradeCard['order'];
        $orderDown = $card['order'];

        $card->update([
            'order' => $orderUp
        ]);
        $tradeCard->update([
            'order' => $orderDown
        ]);

        return Response::success('move success');
    }

    public function moveCard($boardId, $listId, $cardId, $toList){
        //checking board
        $findBoard = $this->board->find($boardId);
        if(!$findBoard){
            return Response::fail('board not found');
        }

        //checking list in board
        $findList = $this->boardList->where('board_id', $findBoard['id'])->find($listId);
        if(!$findList){
            return Response::fail('list not found');
        }

        //checking card
        $findCard = $this->card->where('list_id',$findList['id'])->find($cardId);
        if(!$findCard){
            return Response::fail('card not found');
        }

        //checking toList
        $checkToList = $this->boardList->find($toList);
        if(!$checkToList){
            return Response::fail('list not found');
        }else if($checkToList['board_id'] != $findList['board_id']){
            return Response::fail('move list invalid');
        }

        $countOrder = $this->card->where('list_id',$toList)->count();

        $findCard->update([
            'list_id' => $checkToList['id'],
            'order' => $countOrder+1,
        ]);

        return Response::success('move success');
    }
}
