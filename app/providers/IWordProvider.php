<?php

    /**
     * Interface IWordProvider
     */
    interface IWordProvider
    {
        /**
         * @param int $limit
         *
         * @return mixed
         */
        public function getRandomWords( $limit=3 );

        /**
         * @param $word
         *
         * @return mixed
         */
        public function getDefinitions( $word );
    }