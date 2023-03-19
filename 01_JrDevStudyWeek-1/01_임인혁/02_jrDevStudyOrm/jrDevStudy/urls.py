"""jrDevStudy URL Configuration
    예시:
        함수 기반 뷰
            1. import 추가: from my_app import views
            2. URL 추가: path('', views.home, name='home')

        클래스 기반 뷰
            1. import 추가: from other_app.views import Home
            2. URL 추가: path('', Home.as_view(), name='home')

        다른 URLconf 포함
            1. include() 함수를 가져옵니다: from django.urls import include, path
            2. URL 추가: path('blog/', include('blog.urls'))
"""

from django.contrib import admin
from django.urls import path , include
from ormStudy import urls_orm

urlpatterns = [
    path('admin/', admin.site.urls),
    # orm/ 경로로 맵핑할 객체
    path('orm/', include('ormStudy.urls_orm')),

]
