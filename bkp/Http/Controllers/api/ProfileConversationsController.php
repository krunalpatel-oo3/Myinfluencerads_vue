<?php

namespace App\Http\Controllers\api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Conversation;

use Carbon\Carbon;
use Config;

class ProfileConversationsController extends BaseController
{


    public function index(Request $request, $logged_user_id)
    {
        $loggedUser = auth()->user();
//        if (empty($loggedUser) or $loggedUser->id != $logged_user_id) {
//            return response()->json(['message' => 'Invalid logged user id : ' . $logged_user_id . ' !'],
//                HTTP_RESPONSE_BAD_REQUEST);
//        }

        $empty_img_url                 = config('app.empty_img_url');

        $conversations = Conversation
//            ::getByStatus('A')
            ::getByCreatorOrCompanionId($logged_user_id)
            ->with('creator')
            ->with('companion')
            ->with('latestConversationMessage')
            ->withCount('conversationMessages')
            ->orderBy('conversation.created_at', 'desc')
            ->get()
            ->map(function ($conversationItem) use ($logged_user_id, $empty_img_url) {
                if ($logged_user_id == $conversationItem->creator_id) {
                    $conversationItem->conversation_user_full_name = $conversationItem->companion['full_name'];
                    $companionPhotoImageProps      = User::readUserImageProps($conversationItem->companion['id'], $conversationItem->companion['profile_photo'], true);
                    $conversationItem->conversation_user_image_url = $companionPhotoImageProps['image_url'] ?? $empty_img_url;

                }
                if ($logged_user_id == $conversationItem->companion_id) {
                    $conversationItem->conversation_user_full_name = $conversationItem->creator['full_name'];
                    $creatorPhotoImageProps      = User::readUserImageProps($conversationItem->creator['id'], $conversationItem->creator['profile_photo'], true);
                    $conversationItem->conversation_user_image_url = $creatorPhotoImageProps['image_url'] ?? $empty_img_url ;
                }

                $conversationItem->latest_conversation_message_created_at = $conversationItem->latestConversationMessage->created_at ?? '';
                $conversationItem->latest_conversation_message_text       = $conversationItem->latestConversationMessage->text ?? '';

                return $conversationItem;
            });

        $filteredConversations = $conversations->filter(function ($item) {
            return !empty($item->latestConversationMessage);
        })->values();

        return response()->json([
            'conversations' => $filteredConversations,
        ],
            HTTP_RESPONSE_OK);
    } // public function index(Request $request, $logged_user_id)

}
