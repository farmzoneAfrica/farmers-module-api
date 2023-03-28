pipeline {
    agent any
    environment {
        staging_server = "81.29.72.93"
    }

    stages {
        stage('Deploy to server') {
            steps{
                sh 'scp -r ${WORKSPACE}/* dspyder1@${staging_server}:var/www/html/laravel/'
            }
        }
    }
}
