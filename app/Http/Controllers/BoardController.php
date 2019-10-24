<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\Response;
use App\Models\Board;
use App\Models\BoardList;
use App\Models\BoardMember;
use App\Models\Card;
use App\Models\LoginToken;
use App\User;

use App\Http\Requests\Board\BoardStoreRequest;
use App\Http\Requests\Board\BoardUpdateRequest;

class BoardController extends Controller
{
    private $board;
    private $loginToken;
    private $user;

    public function __construct(Board $board, BoardList $boardList, BoardMember $boardMember, Card $card, LoginToken $loginToken, User $user){
        $this->board = $board;
        $this->boardList = $boardList;
        $this->boardMember = $boardMember;
        $this->card = $card;
        $this->loginToken = $loginToken;
        $this->user = $user;
    }

    public function index()
    {
        $data = $this->board->all();

        return Response::data($data);
    }

    public function create()
    {
        //
    }

    public function store(BoardStoreRequest $request)
    {
        $params = $request->only(['name']);

        //find creator id
        $user = $this->loginToken->where('token','=',$request->input('token'))->first();

        //create board process
        $board = $this->board->create([
            'name' => $params['name'],
            'creator_id' => $user['user_id']
        ]);

        //assign craetor to member
        $this->boardMember->create([
            'board_id' => $board['id'],
            'user_id' => $user['user_id']
        ]);

        return Response::success('create board success');
    }

    public function show(Request $request,$id)
    {
        //get data board
        $data = $this->board->find($id);
        if(!$data){
            return Response::fail('board not found');
        }

        //get data members
        $dataMembers = $this->boardMember->where('board_id',$data['id'])->get();
        $filterMember = $dataMembers->map(function($dataMember){
            $dataMember['id'] = $dataMember->user['id'];
            $dataMember['first_name'] = $dataMember->user['first_name'];
            $dataMember['last_name'] = $dataMember->user['last_name'];
            $dataMember['initial'] = $dataMember->user['first_name'] . ' ' . $dataMember->user['last_name'];
            unset($dataMember->user);
            unset($dataMember['board_id']);
            unset($dataMember['user_id']);
            unset($dataMember['created_at']);
            unset($dataMember['updated_at']);

            return $dataMember;
        });
        
        //get data board lists
        $dataLists = $data->boardList()->get();
        //filtered data lists
        $filterList = $dataLists->map(function($dataList){
            unset($dataList['board_id']);
            unset($dataList['created_at']);
            unset($dataList['updated_at']);

            // get card data
            $dataCards =  $this->card->where('list_id',$dataList['id'])->get();
            $filterCard = $dataCards->map(function($dataCard){
                unset($dataCard['list_id']);
                unset($dataCard['created_at']);
                unset($dataCard['updated_at']);

                return $dataCard;
            });

            //add data card to data list
            $dataList['cards'] = $filterCard;

            //show data board list & card
            return $dataList;
        });

        return Response::data([
            'id' => $data['id'],
            'name' => $data['name'],
            'creator_id' => $data['creator_id'],
            'members' => $filterMember,
            'lists' => $filterList,
        ]);
    }
    

    public function edit($id)
    {
        //
    }

    public function update(BoardUpdateRequest $request, $id)
    {
        $params = $request->only(['name']);

        $data = $this->board->find($id);

        if(!$data){
            return Response::success('data not found');
        }

        $data->update($params);

        return Response::success('update board success');
    }

    public function destroy($id)
    {
        $data = $this->board->find($id);

        if(!$data){
            return Response::success('data not found');
        }

        $data->delete();

        return Response::success('delete board success');
    }

    public function addMember(Request $request, $boardId){
        $params = $request->only(['username']);

        //checking board
        $findBoard = $this->board->find($boardId);
        if(!$findBoard){
            return Response::fail('board not found');
        }

        //checking user with username
        $findUser = $this->user->where('username',$params['username'])->first();
        if(!$findUser){
            return Response::fail('user did not exist');
        }
        
        //checking member
        $checkMember = $this->boardMember->where('user_id',$findUser['id'])->first();
        if(!is_null($checkMember)){
            return Response::fail('user already added');
        }

        $this->boardMember->create([
            'board_id' => $findBoard['id'],
            'user_id' => $findUser['id']
        ]);

        return Response::success('add member success');
    }

    public function deleteMember($boardId, $id){
        //checking board
        $findBoard = $this->board->find($boardId);
        if(!$findBoard){
            return Response::fail('board not found');
        }

        //checking member
        $checkMember = $this->boardMember->find($id);
        if(is_null($checkMember)){
            return Response::fail('user not found');
        }

        $checkMember->delete();

        return Response::success('remove member success');
    }
}
