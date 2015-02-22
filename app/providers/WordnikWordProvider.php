<?php
    /**
     * Class WordnikWordProvider
     */
    class WordnikWordProvider implements IWordProvider
    {
        /**
         * @var
         */
        private $_apiClient;

        /**
         * @var
         */
        private $_wordsApi;

        /**
         * @var
         */
        private $_wordApi;

        /**
         * @return APIClient
         */
        private final function getApiClient()
        {
            if (null === $this->_apiClient) {
                $this->_apiClient = new APIClient('7368e39c17390f685400c051f250145a206b0935eb7421c57', 'http://api.wordnik.com/v4');
            }

            return $this->_apiClient;
        }

        /**
         * @return WordsApi
         */
        private final function getWordsApi()
        {
            if (null === $this->_wordsApi) {
                $this->_wordsApi = new WordsApi($this->getApiClient());
            }

            return $this->_wordsApi;
        }

        /**
         * @return WordApi
         */
        private final function getWordApi()
        {
            if (null === $this->_wordApi) {
                $this->_wordApi = new WordApi($this->getApiClient());
            }

            return $this->_wordApi;
        }

        /**
         * @param int $limit
         *
         * @return array
         */
        public function getRandomWords( $limit = 3 )
        {
            $words = $this->getWordsApi()->getRandomWords(null, null, null, null, null, null, null, null, null, null, null, $limit);

            $returnWords = array();
            foreach ($words as $word) {
                $returnWords[] = $word->word;
            }

            return $returnWords;
        }

        /**
         * @param $word
         *
         * @return array
         */
        public function getDefinitions( $word )
        {
            $definitionList = $this->getWordApi()->getDefinitions($word);

            $definitions = array();
            foreach ($definitionList as $definition) {
                $definitions[] = $definition->text;
            }

            return $definitions;
        }
    }

