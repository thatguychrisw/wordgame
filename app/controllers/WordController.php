<?php

    class WordController extends \Phalcon\Mvc\Controller
    {
        /**
         * @var IWordProvider
         */
        private $_wordProvider;

        public function setWordServiceProvider( IWordProvider $wordServiceProvider )
        {
            $this->_wordProvider = $wordServiceProvider;
        }

        /**
         * @return array
         * @throws \Phalcon\Exception
         */
        public function getRandomWords()
        {
            $wordList = $this->_wordProvider->getRandomWords();
            if (empty($wordList)) {
                throw new \Phalcon\Exception('Could not retrieve a list of words', 500);
            }

            $wordsToUse = array();

            // Get the word to use
            //
            $randomWordIndex = rand(1, count($wordList) - 1);

            $i = 0;
            while ($i < count($wordList)) {
                $isChosenWord = ($i == $randomWordIndex);

                $word = $wordList[$i];
                $definitions = $this->_wordProvider->getDefinitions($word);
                $primaryDefinition = current($definitions);

                $wordsToUse[] = array(
                    'text' => $word,
                    'definition' => $primaryDefinition,
                    'isChosen' => $isChosenWord,
                );

                ++ $i;
            }

            return $wordsToUse;
        }
    }
