pipeline {
    agent any
    stages {
        stage('Checkout Code') {
            steps {
                git branch: 'Testing', url: 'https://github.com/gautamkunjadiya99/Testqa.git'
            }
        }
        stage('Install Dependencies') {
            steps {
                sh 'npm install'
            }
        }
        stage('Install Playwright Browsers') {
            steps {
                sh 'npx playwright install --with-deps'
            }
        }
        stage('Run Playwright Tests') {
            steps {
                sh 'npx playwright test'
            }
        }
        stage('Test Execution') {
             steps {
                  sh 'npx playwright test --reporter=html'
            }
        }
    }
    post {
        always {
            echo 'Publishing Playwright report...'
        }

        success {
            echo 'Tests PASSED ✅'
        }

        failure {
            echo 'Tests FAILED ❌'
        }
    }
}
