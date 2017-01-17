<?php

namespace api\modules\v1\logic;

// 引入私有function
use api\components\Myfun;

// 引入DB模型
use api\modules\v1\models\Questions;
use api\modules\v1\models\Answers;
use api\modules\v1\models\User;

define(DEBUG_QUESTION_LOG, '/opt/logs/debug/QuestionLog-'.date('Y-m-d', time()).'.log');

class L_question
{

################## Controller 区域 ##################
	
	// 获取题目内容
	public static function getinfobyID($p) {
		
		// token校验
		$token_check = L_user::checkToken($p);

		if ($token_check) {
			
			// 判断用户是否授权，未授权用户，则只能返回免费题目
			$user_info = User::findByUserID(base64_decode($p['userID']));
			if (empty($user_info) or ($user_info['status'] != 1)) {
							
				$ret['error_code'] = 103;
				$ret['error_msg'] = '用户未授权';
				$ret['data'] = '';
			} else {
				
				// 从question和answer中读信息
				$question_info = Questions::findInfoByID($p);
				$anwser_info = Answers::findInfoByID($p);
				
				// 过滤不要的数据内容
				$temp = $question_info->attributes;
				unset($temp['id']);
				unset($temp['paper_id']);
				unset($temp['create_time']);
				unset($temp['update_time']);
				unset($temp['is_deleted']);
				unset($temp['correct']);
				$temp['settings'] = json_decode($temp['settings'], true);
				$ret['data']['question_info'] = $temp;
				
				// 过滤不要的数组内容
				foreach ($anwser_info as $row) {
					$temp = $row->attributes;
					unset($temp['id']);
					unset($temp['is_deleted']);
					unset($temp['create_time']);
					unset($temp['update_time']);
					$ret['data']['anwser_info'][] = $temp;
				}
			}
		} else {
			
			$ret['error_code'] = 101;
			$ret['error_msg'] = '验证失败，请重新验证';
			$ret['data'] = '';
		}
		return $ret;
	}
	
	// 获取免费活动
	public static function getfreeinfo($p) {
		
		// token校验
		$token_check = L_user::checkToken($p);

		if ($token_check) {

			$q[1]['question_id'] = 1389;
			$q[2]['question_id'] = 1528;
			$q[3]['question_id'] = 1715;
			$q[4]['question_id'] = 1647;
			$p['paper_id'] = 132;
			$count = 4;

			for ($i = 1; $i <= $count; $i++) {
				
				$p['item_id'] = $i;
				$p['question_id'] = $q[$i];
				
				// 从question和answer中读信息
				$question_info = Questions::findInfoByID($p);
				$anwser_info = Answers::findInfoByID($p);
				
				// 过滤不要的数据内容
				$temp = $question_info->attributes;
				unset($temp['id']);
				unset($temp['paper_id']);
				unset($temp['create_time']);
				unset($temp['update_time']);
				unset($temp['is_deleted']);
				unset($temp['correct']);
				$temp['settings'] = json_decode($temp['settings'], true);
				$ret['data'][$i-1]['question_info'] = $temp;
				
				// 过滤不要的数组内容
				foreach ($anwser_info as $row) {
					$temp = $row->attributes;
					unset($temp['id']);
					unset($temp['is_deleted']);
					unset($temp['create_time']);
					unset($temp['update_time']);
					$ret['data'][$i-1]['anwser_info'][] = $temp;
				}
			}
		} else {
			
			$ret['error_code'] = 101;
			$ret['error_msg'] = '验证失败，请重新验证';
			$ret['data'] = '';
		}
		return $ret;
	}
	
	// 获取paper_id所包含的具体
	public static function getIDs($p) {
		
		// token校验
		$token_check = L_user::checkToken($p);

		if ($token_check) {
			
			// 判断用户是否授权，未授权用户，则只能返回免费题目
			$user_info = User::findByUserID(base64_decode($p['userID']));
			if (empty($user_info) or ($user_info['status'] != 1)) {
			
				// 用户未授权，只返回免费活动				
				$ret['error_code'] = 103;
				$ret['error_msg'] = '用户未授权';
				$ret['data'] = '';
			} else {
				
				$p['page'] = !isset($p['page']) ? 0 : $p['page']; // 分页参数
				$p['limit'] = !isset($p['limit']) ? 0 : $p['limit']; // 分页参数
				
				// 从question中获取paperID值
				$ids = Questions::findInfoByPaperID($p);
				
				// 过滤不要的数组内容
				foreach ($ids as $row) {
					$temp = $row->attributes;
					$q['paper_id'] = $temp['paper_id'];
					$q['question_id'] = $temp['question_id'];
					$q['item_id'] = $temp['index'];
					$ret['data']['ids'][] = $q;
				}
			}
		} else {
			
			$ret['error_code'] = 101;
			$ret['error_msg'] = '验证失败，请重新验证';
			$ret['data'] = '';
		}
		return $ret;
	}
	
	// 计算题目结果是否正确
	public static function submitAnswers($p) {
		
		// token校验
		$token_check = L_user::checkToken($p);

		if ($token_check) {
			
			// 判断用户是否授权，未授权用户，则只能返回免费题目
			$user_info = User::findByUserID(base64_decode($p['userID']));
			if (empty($user_info) or ($user_info['status'] != 1)) {
			
				// 用户未授权，只返回免费活动				
				$ret['error_code'] = 103;
				$ret['error_msg'] = '用户未授权';
				$ret['data'] = '';
			} else {
				
				// 从question中获取paperID值
				$ids = Questions::findAnswerInfoByPaperID($p);
				
				$score = $fail_arr = $correct_arr=0; // 记录数量
				$whole_arr = array();
				
				$index = 0;
				// 过滤不要的数组内容
				foreach ($ids as $row) {
					$temp = $row->attributes;

					if (($p['answers_list'][$index]['q'] == $temp['question_id']) and ($p['answers_list'][$index]['a'] == $temp['correct'])) {
						$correct_arr++;
						$whole_arr[] = 'Y';
						$score += $temp['score'];
					} else {
						$fail_arr++;
						$whole_arr[] = 'N';
					}
					$index++;
				}
				$ret['error_code'] = 0;
				$ret['error_msg'] = '';
				$ret['data']['answers']['correct_num'] = $correct_arr;
				$ret['data']['answers']['fail_num'] = $fail_arr;
				$ret['data']['answers']['score'] = $score;
				$ret['data']['answers']['list'] = $whole_arr;
			}
		} else {
			
			$ret['error_code'] = 101;
			$ret['error_msg'] = '验证失败，请重新验证';
			$ret['data'] = '';
		}
		return $ret;
	}
}