<?php

// 関数ファイル読み込み
require_once '../include/common/function.php';

// モデル読み込み
require_once '../include/model/post_model.php';
require_once '../include/model/main_model.php';
require_once '../include/model/profile_model.php';
require_once '../include/model/follow_model.php';

// ログイン情報を読み込み
include_once '../include/common/start_session.php';

// ログインしていない場合→メニューページへ
include_once '../include/common/goto_menu.php';

// ヘッダー読み込み
include_once '../include/common/hina_header.php';

// ログアウトフォーム表示
include_once '../include/common/logout.php';

//エラー保持用配列
$errors = array();

// modelオブジェクト作成
$main = new main_model();
$post = new post_model();
$profile = new profile_model();
$follow = new follow_model();

// ログインIDを変数に格納する
$login_id  = $_SESSION['login_id'];

// 変数宣言
$color_id  = '';
$post_body = '';
$login_user_info = array();
$user_list = array();
$my_follow_list = array();

//アップロードした画像を配置するsrcパス
$dir_src = '../include/img/src/';

// DBコネクトオブジェクト取得
try {
	$db = get_db_connect();
} catch (PDOException $e) {
	$errors[] = entity_str($e->getMessage());
}

// ログインユーザ情報を取得する
$login_user_info = $main->getMyProfile($db, $login_id);

// プロフィールユーザIDを変数に格納する
$user_profile_id = getGet('user_profile_id');

// プロフィールユーザのプロフィールとタイムラインを取得する
$my_profile = $main->getMyProfile($db, $user_profile_id);
$my_time_line = $main->getMyTimeLine($db, $user_profile_id);

// フォロー一覧を取得
$my_follows = $follow->myFollowUser($db, $user_profile_id);
if (is_array($my_follows)) {
	foreach($my_follows as $my_follow) {
		$my_follow_list[] = $my_follow['follower_user_id'];
	}
}
// フォロー数一覧を取得
$my_follow_num = count($my_follow_list);

// フォロワー一覧を取得
$my_followers = $follow->myFollowerUser($db, $user_profile_id);
$my_follower_num = count($my_followers);

// 鬱イート数一覧を取得
$my_utweet_num = count($main->getMyTimeLine($db, $user_profile_id));

// ユーザ名がクリックされたとき、プロフィールページに遷移する
if (getGet('action_id') === 'profile') {
	// プロフィール画面表示
	include_once '../include/view/my_profile.php';
} else if (getGet('action_id') === 'follow') {
	// プロフィール画面表示
	include_once '../include/view/my_profile.php';
	// フォローユーザー覧画面
	include_once '../include/view/follow_list.php';

} else if (getGet('action_id') === 'follower') {
	// プロフィール画面表示
	include_once '../include/view/my_profile.php';
	// フォロワーユーザ一覧画面
	include_once '../include/view/follower_list.php';
}

if (isPost()) {
	// ユーザプロフィール編集
	if (getPost('action_id') === 'profile_edit') {
		$my_profile = $main->getMyProfile($db, $login_id);
		$my_time_line = $main->getMyTimeLine($db, $login_id);
		include_once '../include/view/my_profile_edit.php';
	} else if (getPost('action_id') === 'profile_edit_complete') {
		// todo: プロフィール更新処理
		$edit_user_name = entity_str(getPost('edit_user_name'));
		if (!isExist($edit_user_name)) {
			$errors[] = 'ユーザネームを入力してください';
		} else if (!isOverText($edit_user_name, 20)) {
			$errors[] = '文字数は20文字以内で入力してください';
		}
		$edit_user_profile = entity_str(getPost('edit_user_profile'));
		if (!isExist($edit_user_profile)) {
			$errors[] = 'プロフィールを入力してください';
		} else if (!isOvertext($edit_user_profile, 200)) {
			$errors[] = '文字数は200文字以内にしてください';
		}
		if (isset($_FILES['edit_user_profile_photo'])) {
		// todo: 画像アップロード入力チェック
			if (!checkPostMaxSize()) {
				$errors[] = 'ファイルサイズは100KB以下にしてください';
			}
			// アップロードファイルチェック
			list($result, $ext, $error_msg) = checkUpdateFile();
			$errors = array_merge($errors, $error_msg);

			if ($result) {
				$name = $_FILES['edit_user_profile_photo']['name'];
				$tmp_name = $_FILES['edit_user_profile_photo']['tmp_name'];

				// 画像保存先ファイルパス
				$move_to = $dir_src . makeRandStr() .$ext;

				// アップロードした一時ファイルを指定した場所へ移動します
				if (!move_uploaded_file($tmp_name, $move_to)) {
					$errors[] = '画像のアップロードに失敗しました';
						$edit_user_profile_photo = '';
				} else {
						$edit_user_profile_photo = $move_to;
				}
			}
			if (count($errors) === 0) {
				if (!$profile->profileEdit($db, $login_id, $edit_user_name, $edit_user_profile, $edit_user_profile_photo)) {
					$errors[] = '更新に失敗しました';
				} else {
					header('HTTP/1.1 303 See Other');
					header('Location: http://localhost/utwitter/htdocs/profile_controller.php?action_id=profile&user_profile_id=' . $login_id);
					exit();
				}
			}
		}
	}
} else {
	// プロフィール画面表示
	include_once '../include/view/my_profile.php';
}

// エラー表示
include_once '../include/common/errors.php';

// フッター読み込み
include_once '../include/common/hina_footer.php';
