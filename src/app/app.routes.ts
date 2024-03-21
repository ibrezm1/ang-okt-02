import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ReservationComponent } from './reservation/reservation.component';
import { ReservationListComponent } from './reservation-list/reservation-list.component';
import { OktaAuthGuard, OktaCallbackComponent } from '@okta/okta-angular';

export const routes: Routes = [
    { path: '', redirectTo: 'home', pathMatch: 'full' },
    { path: 'home', component: HomeComponent },
    { path: 'reservation', component: ReservationComponent , canActivate: [OktaAuthGuard] },
    { path: 'edit/:id', component: ReservationComponent , canActivate: [OktaAuthGuard] },
    { path: 'list', component: ReservationListComponent , canActivate: [OktaAuthGuard] },
    { path: 'login/callback', component: OktaCallbackComponent },
];
