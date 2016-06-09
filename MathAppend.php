<?php
	/**
	 * Class MathAppend
	 * 
	 * 数学的によく使う処理をまとめたクラスです
	 */
	class MathAppend {
	
		/////////////////////////////////////////////////////////////////////////
		//
		// constructor
		//
		/////////////////////////////////////////////////////////////////////////
		
		private function __construct() {
		}
		
		
		
		/////////////////////////////////////////////////////////////////////////
		//
		// public functions
		//
		/////////////////////////////////////////////////////////////////////////
		
		/**
		 * 最大公約数を求めます
		 * 
		 * @param  array $list 比較数値配列
		 * @return int         最大公約数
		 * 
		 * @usage  echo MathAppend::gcd(1071, 1029); // 21
		 */
		public static function gcd(array $list) {
			// validationだけ先に
			$c = count($list);
			if ($c === 0)
				return 0;
			else if ($c === 1)
				return $list[0];
			
			return self::calcGCD($list);
		}
		
		/**
		 * 最小公倍数を求めます
		 * 
		 * @param  array $list 比較数値配列
		 * @return int         最小公倍数
		 * 
		 * @usage  echo MathAppend::lcm(1071, 1029); // 52479
		 */
		public static function lcm(array $list) {
			// validationだけ先に
			$c = count($list);
			if ($c === 0)
				return 0;
			else if ($c === 1)
				return 1;
			
			return self::calcLCM($list);
		}
		
		
		
		/////////////////////////////////////////////////////////////////////////
		//
		// private functions
		//
		/////////////////////////////////////////////////////////////////////////
		
		/**
		 * 最大公約数を求めます(本体)
		 * 
		 * @param  array &$list 比較数値配列
		 * @return int          最大公約数
		 */
		private static function calcGCD(array &$list) {
			$c = count($list);
			
			// ユークリッドの互除法を末尾2要素にかける
			$v = $list[$c - 1] % $list[$c - 2];
			if ($v === 0) {
				if ($c === 2)
					return $list[$c - 2];
				
				// 2要素の最大公約数が決まったら、配列を更新して再帰
				array_pop($list);
				return self::calcGCD($list);
			}
			
			$list[$c - 1] = $list[$c - 2];
			$list[$c - 2] = $v;
			return self::calcGCD($list);
		}
		
		/**
		 * 最小公倍数を求めます(本体)
		 * 
		 * @param  array &$list 比較数値配列
		 * @return int          最小公倍数
		 */
		private static function calcLCM(array &$list) {
			$c = count($list);
			$v = $list[$c - 1] * $list[$c - 2] / self::gcd(array($list[$c - 1], $list[$c - 2]));
			
			if ($c === 2)
				return $v;
			
			$list[$c - 2] = $v;
			array_pop($list);
			return self::calcLCM($list);
		}
	}
?>