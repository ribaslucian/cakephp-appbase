<?php

class OverviewController extends AppController {

    public function admin_index() {
        $this->set('birthdays', $this->birthdays());
    }
    
    /**
     * 
     * @return type
     */
    private function birthdays() {
        $month = date('m');

        $this->loadModel('User');
        $users = $this->User->find('all', [
            'fields' => 'id, email, birthday',
            'order' => 'birthday ASC',
        ]);

        $i = 0;
        foreach ($users as $birthday) {
            $birthday['User']['birthday'] = new Date($birthday['User']['birthday'], 'Y-m-d', 'd-m');
            $birthday = $birthday['User']['birthday']->getDate();
            $birthday = str_replace('-', '/', $birthday);

            $d = explode('/', $birthday);

            if ($d[1] == $month):
                $users[$i]['User']['birthday'] = $birthday;
            else :
                unset($users[$i]);
            endif;
            $i++;
        }

        return $users;
    }


}
