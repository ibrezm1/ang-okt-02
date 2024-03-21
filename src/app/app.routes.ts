import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ReservationComponent } from './reservation/reservation.component';
import { ReservationListComponent } from './reservation-list/reservation-list.component';
import { OktaAuthGuard, OktaCallbackComponent } from '@okta/okta-angular';

export const routes: Routes = [
    { path: '', redirectTo: 'home', pathMatch: 'full' },
    { path: 'home', component: HomeComponent },
    { path: 'reservation', component: ReservationComponent },
    { path: 'edit/:id', component: ReservationComponent },
    { path: 'list', component: ReservationListComponent },
    { path: 'login/callback', component: OktaCallbackComponent },
];
