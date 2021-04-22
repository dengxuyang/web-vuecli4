pipeline {
    agent any
    environment {
		tag="v1.0" //版本号
		projectName="${JOB_NAME}"
		commitHash="${GIT_COMMIT}"
		KUBE_CONFIG_LOCAL=credentials('local-k8s-kube-config')  //开发测试环境的kube凭证
    }
    stages {
		stage('NPM Build') {
			steps {
			    script {
					echo "代码编译打包"
					dir('front/') {
						sh 'npm install --unsafe-perm'
						sh 'npm run build'
					}
					
				}
			}
		}
		stage('Docker Build') {
			steps {
				script {
					echo "生成镜像"
					def pName = "${projectName}"
					def list = pName.split('_')
					dockerName = list[0]
					taget_image="${dockerName}:${tag}"
					sh "docker build --build-arg app=${appName} -t ${taget_image} ."
					sh "docker tag ${taget_image} ${harbor_server}/${harbor_project}/${dockerName}"
					sh "docker tag ${taget_image} ${harbor_server}/${harbor_project}/${dockerName}:${commitHash}"
				}
			}
		}
        stage('Horbor Upload') {
			steps {
				script {
				    docker_path="${WORKSPACE}"
					echo "登录Harbor"
					sh "cd ${docker_path}"
					sh "docker login ${harbor_server} -u ${harbor_account} -p ${harbor_password}"
					echo "生成镜像并推送到Harbor"
					def pName = "${projectName}"
					def list = pName.split('_')
					dockerName = list[0]
					sh "docker push ${harbor_server}/${harbor_project}/${dockerName}:latest"
					sh "docker push ${harbor_server}/${harbor_project}/${dockerName}:${commitHash}"
					echo "删除本地镜像"
                    sh "docker rmi -f \$(docker images|grep ${dockerName}|grep ${tag}|awk '{print \$3}'|head -n 1)"
				}
			}
		}
        stage('Helm Deploy') {
		    steps {
				echo "部署到K8s"
				sh "mkdir -p /root/.kube"
				script {
					def kube_config = env.KUBE_CONFIG_LOCAL
					//sh "echo '${kube_config}' | base64 -d > /root/.kube/config"
					//根据不同环境将服务部署到不同的namespace下，这里使用分支名称
					def pName = "${projectName}"
					def list = pName.split('_')
					dockerName = list[0]
					sh "/usr/local/bin/helm repo update"
					sh "/usr/local/bin/helm upgrade ${dockerName} ${dockerName} --set commitHash=${commitHash}"
				
				}
			}
        }
    }
}


