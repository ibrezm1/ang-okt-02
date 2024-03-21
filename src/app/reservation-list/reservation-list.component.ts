import { Component } from '@angular/core';
import { HomeComponent } from '../home/home.component';
import { ReservationService } from '../reservation.service';
import { Reservation } from '../models/reservation';
import {BrowserModule } from '@angular/platform-browser';
import { CommonModule } from '@angular/common';
import { MatTableModule } from '@angular/material/table';
import { RouterModule} from '@angular/router';
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-reservation-list',
  standalone: true,
  imports: [HomeComponent,CommonModule,MatTableModule,RouterModule,MatButtonModule],
  templateUrl: './reservation-list.component.html',
  styleUrl: './reservation-list.component.css'
})
export class ReservationListComponent {
  reservations: Reservation[] = [];
  displayedColumns: string[] = ['guestId', 'checkInDate', 'guestName', 'guestEmail', 'roomNumber', 'actions'];

  constructor(private reservationService: ReservationService) { }

  ngOnInit() {
    this.reservationService.getAllGuests().subscribe(
      (response: any) => {
        if (response.success) {
          this.reservations = response.data;
          console.log(this.reservations);
        } else {
          console.error('Error occurred:', response.error);
        }
      },
      error => {
        console.error('Error occurred:', error);
      }
    ); 
  }
  deleteReservation(id: number){
    this.reservationService.deleteGuest(id).subscribe(
      (response: any) => {
        if (response.success) {
          this.reservations = this.reservations.filter(reservation => reservation.guestId !== id);
        } else {
          console.error('Error occurred:', response.error);
        }
      },
      error => {
        console.error('Error occurred:', error);
      }
    )
  }
}
