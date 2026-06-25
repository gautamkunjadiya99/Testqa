pipeline {
    agent any
    tools{
        jdk 'JDK25'
        nodejs 'node24'
    }
    stages {
        stage('Checkout Code') {
            steps {
                git branch: 'Testing', url: 'https://github.com/gautamkunjadiya99/Testqa.git'
            }
        }
        stage('Install Dependencies') {
            steps {
                sh 'node -v'
                sh 'npm install'
                sh 'npm run build'
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
        publishHTML (target: [
            reportDir: 'playwright-report',
            reportFiles: 'index.html',
            reportName: 'Playwright Report'
        ])
    }

    success {
        echo 'Tests Passed 🎉'
    }

    failure {
        echo 'Tests Failed ❌'
    }
}
}
