from django.urls import path
from .views_orm import ViewOrm

urlpatterns = [
    path('getMember', ViewOrm.as_view({"get":"get_member"})),
]
