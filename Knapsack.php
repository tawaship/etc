<?php
	/**
	 * Class Knapsack
	 * 
	 * ナップサック問題クラスです
	 */
	class Knapsack {
		
		/////////////////////////////////////////////////////////////////////////
		//
		// properties
		//
		/////////////////////////////////////////////////////////////////////////
		
		/**
		 * 入れられるアイテムの総容量の上限
		 * 
		 * @var int
		 */
		private $_maxCapacity;
		
		/**
		 * 入れられるアイテム数の上限
		 * 
		 * @var int
		 */
		private $_maxCount;
		
		/**
		 * 候補となるアイテム群の容量
		 * 
		 * @var array
		 */
		private $_capacities;
		
		/**
		 * 候補となるアイテム群の価値
		 * 
		 * @var array
		 */
		private $_values;
		
		/**
		 * 候補となるアイテムの個数
		 * 
		 * @var int
		 */
		private $_itemCount;
		
		/**
		 * 結果メモ
		 * 
		 * @var array
		 */
		private $_memory = array();
		
		
		
		/////////////////////////////////////////////////////////////////////////
		//
		// constructor
		//
		/////////////////////////////////////////////////////////////////////////
		
		/**
		 * @param int   $maxCapacity ナップサックの容量上限
		 * @param array $capacities  候補となるアイテム群の容量配列
		 * @param array $values      候補となるアイテム群の価値配列
		 * @param int   $maxCount    ナップサックの個数上限
		 */
		public function __construct($maxCapacity, array $capacities, array $values = null, $maxCount = null) {
			$this->_maxCapacity = $maxCapacity;
			$this->_capacities  = $capacities;
			$this->_itemCount   = count($this->_capacities);
			$this->_values      = is_null($values) ? $capacities : $values; // 価値設定がなければ、容量＝価値
			$this->_maxCount    = is_null($maxCount) ? $this->_itemCount : $maxCount; // 個数上限設定がなければ、候補数＝個数上限
			$this->_memory      = array_fill(0, $this->_itemCount, array());
		}
		
		
		
		/////////////////////////////////////////////////////////////////////////
		//
		// public functions
		//
		/////////////////////////////////////////////////////////////////////////
		
		/**
		 * 最大の価値となるKnapsackItemsの組み合わせを求めます
		 * 
		 * @return array
		 */
		public function getMaxCombination() {
			return $this->calc(0, $this->_maxCapacity);
		}
		
		
		/////////////////////////////////////////////////////////////////////////
		//
		// private functions
		//
		/////////////////////////////////////////////////////////////////////////
		
		/**
		 * 最大の価値となるKnapsackItemsの組み合わせを求めます(本体)
		 * 
		 * @param int $i     参照するアイテム配列index
		 * @param int $j     ナップサックに入れたアイテムの総容量
		 * @param int $count ナップサックに入れたアイテムの個数
		 * @return array
		 */
		private function calc($i, $j, $count = 0) {
			// ものが尽きた
			if ($i == $this->_itemCount)
				return new KnapsackItems();
			
			// メモ
			if (isset($this->_memory[$i][$j]))
				return $this->_memory[$i][$j];
			
			// 個数上限の場合
			if ($count == $this->_maxCount)
				return new KnapsackItems();
			
			// 容量不足の場合
			if ($j < $this->_capacities[$i]) {
				$this->_memory[$i][$j] = new KnapsackItems();
				$s = $this->calc($i + 1, $j, $count);
				$this->_memory[$i][$j]->keys = $s->keys;
				$this->_memory[$i][$j]->sum  = $s->sum;
				
				return $this->_memory[$i][$j];
			}
			
			$s1 = $this->calc($i + 1, $j, $count);
			$s2 = $this->calc($i + 1, $j - $this->_capacities[$i], $count + 1);
			
			$this->_memory[$i][$j] = new KnapsackItems();
			if ($s1->sum >= $s2->sum + $this->_values[$i]) {
				$this->_memory[$i][$j]->keys = $s1->keys;
				$this->_memory[$i][$j]->sum  = $s1->sum;
			} else {
				$this->_memory[$i][$j]->keys = $s2->keys;
				$this->_memory[$i][$j]->keys[] = $i;
				$this->_memory[$i][$j]->sum  = $s2->sum + $this->_values[$i];
			}
			
			return $this->_memory[$i][$j];
		}
	}
	
	
	
	/**
	 * Class KnapsackItems
	 * 
	 * ナップサックの組み合わせデータです
	 */
	class KnapsackItems {
		public $keys = array();
		public $sum  = 0;
	}
?>