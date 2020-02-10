<template>
  <div class="rab">
    <v-toolbar dark color="cyan">
      <v-toolbar-title>RAB</v-toolbar-title>
      <v-divider
        class="mx-4"
        inset
        vertical
      ></v-divider>

      <v-text-field
          flat
          solo-inverted
          hide-details
          prepend-inner-icon="search"
          label="Search"
          class="hidden-sm-and-down"
          color="blue"
          v-model="search"
          dense
      >
      </v-text-field>
    
      <div class="flex-grow-1"></div>
      <v-dialog v-model="dialog" width="750px" max-height="200px">  
        <template v-slot:activator="{ on }">
          <v-btn color="blue" dark v-on="on">New</v-btn>
        </template>
        <v-card color="">

          <v-toolbar dark color="teal">
            <v-btn icon dark @click="dialog = false">
              <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>New RAB</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn dark text @click="addAllItem">Save</v-btn>
            </v-toolbar-items>
          </v-toolbar>

          <template>
            <v-card>
              <v-tabs 
                v-model="tab"
                color="white"
                background-color="blue"
              >
                <v-tab ripple href='#tab-1'>
                  <v-icon left>payment</v-icon>
                  Data
                </v-tab>
                <v-tab ripple href='#tab-2'>
                  <v-icon>home</v-icon>
                  Building
                </v-tab>
                <v-tab ripple href='#tab-3'>
                  <v-icon left>group_work</v-icon>
                  Floor
                </v-tab>
                <v-tab ripple href='#tab-4'>
                  <v-icon left>work</v-icon>
                  Sub
                </v-tab>
                <v-tab ripple href='#tab-5'>
                  <v-icon left>work_outline</v-icon>
                  Detail 
                </v-tab>
                <!-- <v-tab ripple href='#tab-6'>
                  <v-icon left>remove_red_eye</v-icon>
                  Adjustment
                </v-tab> -->

                <!-- Fom RAB awal -->
                <v-tab-item value='tab-1'>
                  <Vform> 
                    <v-card-text>
                      <v-layout>
                        <v-text-field
                          v-model="rab.kode"
                          label="ID"
                        >
                        </v-text-field>
                      </v-layout>

                      <v-layout>
                        <v-select
                          v-model="rab.id_project"
                          label="Project"
                          :items="project"
                          item-text="name"
                          item-value="id_project" 
                          :return-object="false"
                          ></v-select>
                      </v-layout>

                      <v-layout>
                        <v-text-field
                          v-model="rab.desc"
                          label="Note"
                          >
                        </v-text-field>
                      </v-layout>

                      <v-layout>
                        <v-text-field
                          v-model="rab.total_rab"
                          label="Nominal"
                        ></v-text-field>
                      </v-layout>
                    </v-card-text>
                  </Vform>
                </v-tab-item>
                <!-- Form Structure -->
                <v-tab-item value='tab-2'>
                  <!-- <v-data-table
                    :headers="headers_structure"
                    :items="structure"
                    height="150px">

                    <template v-slot:top>
                      <v-toolbar>
                        <v-toolbar-title>Building</v-toolbar-title>
                        <v-divider
                          class="mx-4"
                          inset
                          vertical
                        ></v-divider>
                        
                        <v-text-field
                            flat
                            solo-inverted
                            hide-details
                            v-model="gedung"
                        >
                        </v-text-field>
                        <v-btn 
                          class="ma-3" 
                          color="light-green accent-1" 
                          @click="addStructure"
                        >
                          Add
                        </v-btn>
                      </v-toolbar>
                    </template>

                    <template v-slot:item.action="{ item }">
                      <v-dialog v-model="dialog9" max-width="290px">
                        <template v-slot:activator="{ on }">
                          <v-icon
                            small
                            color="red"
                            v-on="on"
                            @click="itemHandlerStructure(item)"
                          >
                            delete
                          </v-icon>
                        </template>
                          <v-card>
                            <v-card-title class="headline">Confirmation</v-card-title>
                              <v-card-text>Are you sure want to delete this building?</v-card-text>
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn color="green darken-1" text @click="dialog9 = false; deleteStructure(structure_data.id_structure)">Yes</v-btn>
                              <v-btn color="red darken-1" text @click="dialog9 = false">No</v-btn>
                            </v-card-actions>
                          </v-card>
                      </v-dialog>
                    </template>
                  </v-data-table> -->

                  <v-form>
                    <v-card-text>
                      <VBtn
                        color="light-blue darken-4"
                        fab dark
                        @click="tambahS=true"
                      >
                      Add  
                      </VBtn>
                      
                      <v-flex class="text-md-center" sm12 mt-2>
                        <VCard
                          v-for="(detail_structure,index) in Structure"
                          :key="index"
                          > 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="deletestructure(detail_structure)"
                                >
                                <v-icon>remove_circle</v-icon>
                            </v-btn>
                            <!-- buat ditampilkan setelah di clik addList -->
                            <v-flex >
                              <v-select
                                label="Building" 
                                class="pa-1"
                                v-model="detail_structure.id_structure"
                                item-text="name"
                                item-value="id_structure"
                                :items="Structure"
                                disabled 
                              ></v-select>
                            </v-flex>
                          </v-card-title>
                        </Vcard>
                      </v-flex>
                        
                      <v-layout v-if="tambahS">
                        <v-flex class="text-md-center" sm12 mt-2>
                          <VCard> 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="tambahS=false"
                                >
                                <v-icon>remove_circle</v-icon>
                            </v-btn>
                            <v-btn 
                                icon
                                color="green"
                                dark @click="addstructure();tambahS=false"
                                >
                                <v-icon>add_circle</v-icon>
                            </v-btn>
                            <!-- buat pertama kali input data untuk addList -->
                              <v-flex>
                                <v-select
                                  v-model="structure_data.id_structure"
                                  :items="structure"
                                  label="Building"
                                  item-text="name"
                                  item-value="id_structure"
                                >
                                </v-select>
                              </v-flex>
                            </v-card-title>
                          </Vcard>
                        </v-flex>
                      </v-layout>
                    </v-card-text>
                  </v-form>
                </v-tab-item>
                <!-- Form Floor -->
                <v-tab-item value='tab-3'>
                  <!-- <v-data-table
                    :headers="headers_group"
                    :items="sub"
                    height="150px">

                    <template v-slot:top>
                      <v-toolbar>
                        <v-toolbar-title>Floor</v-toolbar-title>
                        <v-divider
                          class="mx-4"
                          inset
                          vertical
                        ></v-divider>
                        
                        <v-text-field
                            flat
                            solo-inverted
                            hide-details
                            v-model="sub_item"
                        >
                        </v-text-field>
                        <v-btn 
                          class="ma-3" 
                          color="light-green accent-1" 
                          @click="addGroup"
                        >
                          Add
                        </v-btn>
                      </v-toolbar>
                    </template>

                    <template v-slot:item.action="{ item }">
                      <v-dialog v-model="dialog10" max-width="290px">
                        <template v-slot:activator="{ on }">
                          <v-icon
                            small
                            color="red"
                            v-on="on"
                            @click="itemHandlerGroup(item)"
                          >
                            delete
                          </v-icon>
                        </template>
                            <v-card>
                              <v-card-title class="headline">Confirmation</v-card-title>
                                <v-card-text>Are you sure want to delete this floor?</v-card-text>
                              <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="green darken-1" text @click="dialog9 = false; deleteGroup(group_data.id_group)">Yes</v-btn>
                                <v-btn color="red darken-1" text @click="dialog9 = false">No</v-btn>
                              </v-card-actions>
                            </v-card>
                      </v-dialog>
                    </template>
                  </v-data-table> -->

                  <v-data-table
                    :headers="headers_detail_building"
                    :items="Structure"
                    height="150px">

                    <template v-slot:top>
                      <v-toolbar>
                        <v-toolbar-title>Detail Building</v-toolbar-title>
                        <v-divider
                          class="mx-4"
                          inset
                          vertical
                        ></v-divider>
                      </v-toolbar>
                    </template>

                    <template v-slot:item.action="{ item }">
                      <VBtn
                        fab dark
                        color="light-blue darken-4"
                        small
                        @click="tambahF=true;itemStructure(item)"
                      >
                      Add
                      </VBtn>
                    </template>
                  </v-data-table>

                  <v-form>
                    <v-card-text>
                      <v-flex class="text-md-center" sm12 mt-2>
                        <VCard
                          v-for="(detail_group,index) in Groups"
                          :key="index"
                          > 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="deletefloor(detail_group)"
                                >
                                <v-icon>remove_circle</v-icon>
                            </v-btn>
                            <!-- buat ditampilkan setelah di clik addList -->
                            <v-flex xs12 sm4 md4>
                              <v-select
                                label="Building" 
                                class="pa-1"
                                v-model="detail_group.id_structure"
                                item-text="structure"
                                item-value="id_structure"
                                :items="Groups"
                                disabled 
                              ></v-select>
                            </v-flex>
                          
                            <v-flex xs12 sm4 md4>
                              <v-select
                              label="Floor*" 
                              class="pa-1"
                              v-model="detail_group.id_group"
                              :items="Groups"
                              item-text="name"
                              item-value="id_group"
                              disabled
                              ></v-select>
                            </v-flex>
                          </v-card-title>
                        </Vcard>
                      </v-flex>
                        
                      <v-layout v-if="tambahF">
                        <v-flex class="text-md-center" sm12 mt-2>
                          <VCard> 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="tambahF=false"
                                >
                                <v-icon>remove_circle</v-icon>
                            </v-btn>
                            <v-btn 
                                icon
                                color="green"
                                dark @click="addfloor();tambahF=false"
                                >
                                <v-icon>add_circle</v-icon>
                            </v-btn>
                            <!-- buat pertama kali input data untuk addList -->
                              <v-flex xs12 sm4 md4>
                                <v-select
                                  label="Building" 
                                  class="pa-1"
                                  v-model="structure_unit.id_structure"
                                  item-text="name"
                                  item-value="id_structure"
                                  :items="Structure"
                                  required 
                                  disabled
                                ></v-select>
                              </v-flex>
                              
                              <v-flex xs12 sm4 md4>
                                <v-select
                                label="Floor*" 
                                class="pa-1"
                                v-model="group_data.id_group"
                                :items="sub"
                                item-text="name"
                                item-value="id_group"
                                required
                                ></v-select>
                              </v-flex>

                              </v-card-title>
                          </Vcard>
                        </v-flex>
                      </v-layout>
                    </v-card-text>
                  </v-form>
                </v-tab-item>
                <!-- Form Type of Task -->
                <v-tab-item value='tab-4'>
                  <v-layout>
                    <v-flex>
                      <v-data-table
                        :headers="headers_detail_floor"
                        :items="Groups"
                        height="150px">

                        <template v-slot:top>
                          <v-toolbar>
                            <v-toolbar-title>Detail Floor</v-toolbar-title>
                            <v-divider
                              class="mx-4"
                              inset
                              vertical
                            ></v-divider>
                          </v-toolbar>
                        </template>

                        <template v-slot:item.action="{ item }">
                          <VBtn
                            fab dark
                            color="light-blue darken-4"
                            small
                            @click="tambahT=true;itemGroups(item)"
                          >
                          Add
                          </VBtn>
                        </template>
                      </v-data-table>
                    </v-flex>
                    
                    <!-- <v-flex>
                      <v-data-table
                        :headers="headers_sub"
                        :items="type"
                        height="150px">

                        <template v-slot:top>
                          <v-toolbar>
                            <v-toolbar-title>Task Group</v-toolbar-title>
                            <v-divider
                              class="mx-4"
                              inset
                              vertical
                            ></v-divider>
                            
                            <v-text-field
                                flat
                                solo-inverted
                                hide-details
                                v-model="sub_item"
                            >
                            </v-text-field>
                            <v-btn 
                              class="ma-3" 
                              color="light-green accent-1" 
                              @click="addTaskSub"
                            >
                              Add
                            </v-btn>
                          </v-toolbar>
                        </template>

                        <template v-slot:item.action="{ item }">
                          <v-dialog v-model="dialog10" max-width="290px">
                            <template v-slot:activator="{ on }">
                              <v-icon
                                small
                                color="red"
                                v-on="on"
                                @click="itemHandlerSub(item)"
                              >
                                delete
                              </v-icon>
                            </template>
                                <v-card>
                                  <v-card-title class="headline">Confirmation</v-card-title>
                                    <v-card-text>Are you sure want to delete this sub task?</v-card-text>
                                  <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="green darken-1" text @click="dialog10 = false; deleteTaskSub(tasksub_data.id_sub)">Yes</v-btn>
                                    <v-btn color="red darken-1" text @click="dialog10 = false">No</v-btn>
                                  </v-card-actions>
                                </v-card>
                          </v-dialog>
                        </template>
                      </v-data-table>
                    </v-flex> -->
                  </v-layout>

                  <v-form>
                    <v-card-text>
                    <v-flex class="text-md-center" sm12 mt-2>
                      <VCard
                        v-for="(detail_task,index) in TaskSub"
                        :key="index"
                        > 
                          <v-card-title>
                          <v-btn 
                              icon
                              color="red"
                              dark @click="deletetasksub(detail_task)"
                              >
                              <v-icon>remove_circle</v-icon>
                          </v-btn>
                          <!-- buat ditampilkan setelah di clik addList -->
                          <v-flex xs11 sm3 md3>
                            <v-select
                              label="Building" 
                              class="pa-1"
                              v-model="detail_task.id_structure"
                              item-text="structure"
                              item-value="id_structure"
                              :items="TaskSub"
                              disabled
                            ></v-select>
                          </v-flex>

                          <v-flex xs11 sm3 md3>
                            <v-select
                              label="Floor" 
                              class="pa-1"
                              v-model="detail_task.id_groups"
                              item-text="groups"
                              item-value="id_groups"
                              :items="TaskSub"
                              disabled 
                            ></v-select>
                          </v-flex>

                          <v-flex xs12 sm4 md4>
                            <v-select
                              label="Type of Task" 
                              class="pa-1"
                              v-model="detail_task.id_sub"
                              item-text="name"
                              item-value="id_sub"
                              :items="type"
                              disabled 
                            ></v-select>
                          </v-flex>

                        </v-card-title>
                      </Vcard>
                    </v-flex>
                      
                    <v-layout>
                      <v-layout v-if="tambahT">
                        <v-flex class="text-md-center" sm12 mt-2>
                          <VCard> 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="tambahT=false"
                            >
                            <v-icon>remove_circle</v-icon>
                            </v-btn>
                            <v-btn 
                                icon
                                color="green"
                                dark @click="addtasksub();tambahT=false"
                                >
                                <v-icon>add_circle</v-icon>
                            </v-btn>
                            <v-flex xs11 sm3 md3>
                              <v-select
                                label="Building" 
                                class="pa-1"
                                v-model="group_unit.id_structure"
                                item-text="structure"
                                item-value="id_structure"
                                :items="Groups"
                                disabled
                              ></v-select>
                            </v-flex>
                          
                            <v-flex xs11 sm3 md3>
                              <v-select
                              label="Floor*" 
                              class="pa-1"
                              v-model="group_unit.id_group"
                              :items="Groups"
                              item-text="groups"
                              item-value="id_group"
                              disabled
                              ></v-select>
                            </v-flex>

                            <v-flex xs12 sm4 md4>
                              <v-select
                              label="Type of Task" 
                              class="pa-1"
                              v-model="tasksub_data.id_sub"
                              item-text="name"
                              item-value="id_sub"
                              :items="type"
                              required 
                              ></v-select>
                            </v-flex>
                            </v-card-title>
                          </Vcard>
                        </v-flex>
                      </v-layout>
                    </v-layout>
                    </v-card-text>
                  </v-form>
                </v-tab-item>
                <!-- Form Detail -->
                <v-tab-item value='tab-5'>
                  <v-flex>
                    <v-data-table
                      :headers="headers_detail_task"
                      :items="TaskSub"
                      height="150px">

                      <template v-slot:top>
                        <v-toolbar>
                          <v-toolbar-title>Detail Task Group</v-toolbar-title>
                          <v-divider
                            class="mx-4"
                            inset
                            vertical
                          ></v-divider>
                        </v-toolbar>
                      </template>

                      <template v-slot:item.action="{ item }">
                        <!-- <VBtn
                          fab dark
                          color="light-blue darken-4"
                          small
                          @click="itemTask(item);tambah=true;"
                        >
                        Add
                        </VBtn> -->
                        
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-btn 
                              icon
                              color="light-blue darken-4"
                              dark @click="filterAHS(item);tambah=true"
                              v-on="on"
                              >
                            <v-icon>add_circle</v-icon>
                            </v-btn>
                          </template>
                          <span>Add AHS</span>
                        </v-tooltip>

                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-btn 
                              icon
                              color="light-green darken-4"
                              dark @click="filterAHSAdjustment(item);tambahAdjust=true"
                              v-on="on"
                              >
                            <v-icon>add_box</v-icon>
                            </v-btn>
                          </template>
                          <span>Add AHS Adjust</span>
                        </v-tooltip>


                        <!-- <VBtn
                          fab dark
                          color="green"
                          small
                          @click="itemAdjust(item);tambahAdjust=true;"
                        >
                        Adjust
                        </VBtn> -->
                      </template>
                    </v-data-table>
                  </v-flex>

                  <v-card>
                    <v-form>
                      <v-card-text>
                        <v-flex class="text-md-center" sm12 mt-2>
                          <VCard
                            v-for="(detail,index) in details"
                            :key="index"
                          > 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="deleteList(detail)"
                                >
                                <v-icon>remove_circle</v-icon>
                            </v-btn>

                            <v-flex xs11 sm3 md3>
                              <v-select
                                label="Building" 
                                class="pa-1"
                                v-model="detail.id_structure"
                                item-text="structure"
                                item-value="id_structure"
                                :items="details"
                                disabled 
                              ></v-select>
                            </v-flex>

                            <v-flex xs11 sm3 md3>
                              <v-select
                                label="Floor" 
                                class="pa-1"
                                v-model="detail.id_groups"
                                item-text="groups"
                                item-value="id_groups"
                                :items="details"
                                disabled 
                              ></v-select>
                            </v-flex>

                            <v-flex xs12 sm4 md4>
                              <v-select
                                label="Type of Task" 
                                class="pa-1"
                                v-model="detail.id_sub"
                                item-text="name"
                                item-value="id_sub"
                                :items="details"
                                disabled 
                              ></v-select>
                            </v-flex>

                            <v-flex xs12 sm4 md4 v-if="detail.id_ahs !=null"> 
                              <v-select 
                                label="AHS" 
                                class="pa-1"
                                v-model="detail.id_ahs"
                                item-text="ahs"
                                item-value="id_ahs"
                                :items="details"
                                disabled 
                              ></v-select>
                            </v-flex>

                            <v-flex xs10 sm2 md2 v-if="detail.id_ahs !=null">
                              <v-select
                                label="HSP" 
                                class="pa-1"
                                v-model="detail.id_ahs"
                                item-text="sub_total"
                                item-value="id_ahs"
                                :items="details"
                                disabled
                              ></v-select>
                            </v-flex>

                            <v-flex xs12 sm4 md4 v-if="detail.id_ahs_adjust !=null"> 
                              <v-select 
                                label="AHS Adjust*" 
                                class="pa-1"
                                v-model="detail.id_ahs_adjust"
                                item-text="ahs_adjust"
                                item-value="id_ahs_adjust"
                                :items="details"
                                disabled 
                              ></v-select>
                            </v-flex>
                            
                            <v-flex xs10 sm2 md2 v-if="detail.id_ahs_adjust !=null">
                              <v-select
                                label="HSP Adjust*" 
                                class="pa-1"
                                v-model="detail.id_ahs_adjust"
                                item-text="sub_total_adjust"
                                item-value="id_ahs_adjust"
                                :items="details"
                                disabled
                              ></v-select>
                            </v-flex>

                            <v-flex xs10 sm2 md2>
                              <v-text-field
                                v-model="detail.volume"
                                label="Volume"
                                class="pa-1"
                                disabled
                              >
                              </v-text-field>
                            </v-flex>

                            <v-flex xs10 sm2 md2>
                              <v-text-field
                                v-model="detail.coefficient"
                                label="Adjustment*"
                                class="pa-1"
                                disabled
                              >
                              </v-text-field>
                            </v-flex>

                            </v-card-title>
                          </Vcard>
                        </v-flex>

                        <v-layout v-if="tambah">
                          <v-flex class="text-md-center" sm12 mt-2>
                            <VCard> 
                              <v-card-title>
                                <v-btn 
                                  icon
                                  color="red"
                                  dark @click="tambah=false"
                                  >
                                  <v-icon>remove_circle</v-icon>
                                </v-btn>
                                <v-btn 
                                  icon
                                  color="green"
                                  dark @click="addList()"
                                  >
                                  <v-icon>add_circle</v-icon>
                                </v-btn>
                                <!-- <v-btn
                                  icon 
                                  color="blue"
                                  @click="filterAHSAdjustment();tambahAdjust=true"
                                >
                                <v-icon>remove_red_eye</v-icon>
                                </v-btn> -->
                                <!-- buat tambah data -->
                                <v-flex xs11 sm3 md3>
                                  <v-select
                                    label="Building" 
                                    class="pa-1"
                                    v-model="tasksub_unit.id_structure"
                                    item-text="structure"
                                    item-value="id_structure"
                                    :items="TaskSub"
                                    disabled 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs11 sm3 md3>
                                  <v-select
                                    label="Floor" 
                                    class="pa-1"
                                    v-model="tasksub_unit.id_groups"
                                    item-text="groups"
                                    item-value="id_groups"
                                    :items="TaskSub"
                                    disabled 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs12 sm4 md4>
                                  <v-select
                                    label="Type of Task" 
                                    class="pa-1"
                                    v-model="tasksub_unit.id_sub"
                                    item-text="name"
                                    item-value="id_sub"
                                    :items="TaskSub"
                                    disabled 
                                  ></v-select>
                                </v-flex>
                                
                                <v-flex xs12 sm4 md4>
                                  <v-select 
                                    label="AHS" 
                                    class="pa-1"
                                    v-model="AHS.id_ahs"
                                    item-text="name"
                                    item-value="id_ahs"
                                    :items="filterAHSAll"
                                    @change="getSelectedIndex"
                                    required 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs10 sm2 md2>
                                  <v-select
                                    label="HSP" 
                                    class="pa-1"
                                    v-model="AHS.id_ahs"
                                    item-text="total"
                                    item-value="id_ahs"
                                    :items="filterAHSAll"
                                    @change="getSelectedIndex"
                                    disabled
                                    required 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs10 sm2 md2>
                                  <v-text-field
                                    v-model="rab_details.volume"
                                    label="Volume"
                                    class="pa-1"
                                  >
                                  </v-text-field>
                                </v-flex>

                                <v-flex xs10 sm2 md2>
                                  <v-text-field
                                    v-model="rab_details.coefficient"
                                    label="Adjustment*"
                                    class="pa-1"
                                  >
                                  </v-text-field>
                                </v-flex>

                              </v-card-title>
                            </Vcard>
                          </v-flex>
                        </v-layout> 

                        <v-layout v-if="tambahAdjust">
                          <!-- <v-flex class="text-md-center" sm12 mt-2>
                            <VCard
                              v-for="(detail,index) in details"
                              :key="index"
                            > 
                              <v-card-title>
                              <v-btn 
                                  icon
                                  color="red"
                                  dark @click="deleteList(detail,detail.id_ahs_adjust)"
                                  >
                                  <v-icon>remove_circle</v-icon>
                              </v-btn>

                              <v-flex xs11 sm3 md3>
                                <v-select
                                  label="Building" 
                                  class="pa-1"
                                  v-model="detail.id_structure"
                                  item-text="structure"
                                  item-value="id_structure"
                                  :items="details"
                                  disabled 
                                ></v-select>
                              </v-flex>

                              <v-flex xs11 sm3 md3>
                                <v-select
                                  label="Floor" 
                                  class="pa-1"
                                  v-model="detail.id_groups"
                                  item-text="groups"
                                  item-value="id_groups"
                                  :items="details"
                                  disabled 
                                ></v-select>
                              </v-flex>

                              <v-flex xs12 sm4 md4>
                                <v-select
                                  label="Type of Task" 
                                  class="pa-1"
                                  v-model="detail.id_sub"
                                  item-text="name"
                                  item-value="id_sub"
                                  :items="details"
                                  disabled 
                                ></v-select>
                              </v-flex>

                              <v-flex xs12 sm4 md4> 
                                <v-select 
                                  label="AHS Adjust" 
                                  class="pa-1"
                                  v-model="detail.id_ahs"
                                  item-text="ahs_adjust"
                                  item-value="id_ahs_adjust"
                                  :items="details"
                                  disabled 
                                ></v-select>
                              </v-flex>

                              <v-flex xs10 sm2 md2>
                                <v-select
                                  label="HSP Adjust" 
                                  class="pa-1"
                                  v-model="detail.id_ahs_adjust"
                                  item-text="sub_total"
                                  item-value="id_ahs_adjust"
                                  :items="details"
                                  disabled
                                ></v-select>
                              </v-flex>

                              <v-flex xs12 sm4 md4> 
                                <v-select 
                                  label="AHS Adjust*" 
                                  class="pa-1"
                                  v-model="detail.id_ahs_adjust"
                                  item-text="ahs_adjust"
                                  item-value="id_ahs_adjust"
                                  :items="details"
                                  disabled 
                                ></v-select>
                              </v-flex>
                              
                              <v-flex xs10 sm2 md2>
                                <v-select
                                  label="HSP Adjust*" 
                                  class="pa-1"
                                  v-model="detail.id_ahs_adjust"
                                  item-text="sub_total_adjust"
                                  item-value="id_ahs_adjust"
                                  :items="details"
                                  disabled
                                ></v-select>
                              </v-flex>

                              <v-flex xs10 sm2 md2>
                                <v-text-field
                                  v-model="detail.volume"
                                  label="Volume"
                                  class="pa-1"
                                  disabled
                                >
                                </v-text-field>
                              </v-flex>

                              <v-flex xs10 sm2 md2>
                                <v-text-field
                                  v-model="detail.coefficient"
                                  label="Adjustment*"
                                  class="pa-1"
                                  disabled
                                >
                                </v-text-field>
                              </v-flex>

                              </v-card-title>
                            </Vcard>
                          </v-flex> -->

                          <v-flex class="text-md-center" sm12 mt-2>
                            <VCard> 
                              <v-card-title>
                                <v-btn 
                                  icon
                                  color="red"
                                  dark @click="tambahAdjust=false"
                                  >
                                  <v-icon>remove_circle</v-icon>
                                </v-btn>
                                <v-btn 
                                  icon
                                  color="green"
                                  dark @click="addList()"
                                  >
                                  <v-icon>add_circle</v-icon>
                                </v-btn>
                                
                                <v-flex xs11 sm3 md3>
                                  <v-select
                                    label="Building" 
                                    class="pa-1"
                                    v-model="tasksub_unit.id_structure"
                                    item-text="structure"
                                    item-value="id_structure"
                                    :items="TaskSub"
                                    disabled 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs11 sm3 md3>
                                  <v-select
                                    label="Floor" 
                                    class="pa-1"
                                    v-model="tasksub_unit.id_groups"
                                    item-text="groups"
                                    item-value="id_groups"
                                    :items="TaskSub"
                                    disabled 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs12 sm4 md4>
                                  <v-select
                                    label="Type of Task" 
                                    class="pa-1"
                                    v-model="tasksub_unit.id_sub"
                                    item-text="name"
                                    item-value="id_sub"
                                    :items="TaskSub"
                                    disabled 
                                  ></v-select>
                                </v-flex>
                                
                                <v-flex xs12 sm4 md4>
                                  <v-select 
                                    label="AHS Adjust*" 
                                    class="pa-1"
                                    v-model="ahs_adjust.id_ahs_adjust"
                                    item-text="name"
                                    item-value="id_ahs_adjust"
                                    :items="filterAHSAdjust"
                                    @change="getSelectedIndexAdjust"
                                    required 
                                  ></v-select>
                                </v-flex>

                                <v-flex xs10 sm2 md2>
                                  <v-select
                                    label="HSP Adjust*" 
                                    class="pa-1"
                                    v-model="ahs_adjust.id_ahs_adjust"
                                    item-text="total"
                                    item-value="id_ahs_adjust"
                                    :items="filterAHSAdjust"
                                    disabled
                                  ></v-select>
                                </v-flex>

                                <v-flex xs10 sm2 md2>
                                  <v-text-field
                                    v-model="rab_details.volume"
                                    label="Volume"
                                    class="pa-1"
                                  >
                                  </v-text-field>
                                </v-flex>
                                
                                <v-flex xs10 sm2 md2>
                                  <v-select
                                    label="Adjustment*" 
                                    class="pa-1"
                                    v-model="ahs_adjust.id_ahs_adjust"
                                    item-text="adjustment"
                                    item-value="id_ahs_adjust"
                                    :items="filterAHSAdjust"
                                    disabled
                                  ></v-select>
                                </v-flex>

                              </v-card-title>
                            </Vcard>
                          </v-flex>
                        </v-layout>

                      </v-card-text>
                    </v-form>
                  </v-card>
                </v-tab-item>
                <!-- Form Adjustment -->
                <!-- <v-tab-item value="tab-6">
                    <v-data-table
                      :headers="headers_filter_materials"
                      height="150px"
                      :items="filterMaterialsAll"
                    >
                    
                    <template v-slot:item.adjust="props">
                      <v-edit-dialog
                        :return-value.sync="props.item.adjust"
                        @save="save(props)"
                        lazy
                        persistent
                        dark
                      > {{ props.item.adjust }}
                        <template v-slot:input>
                          <v-text-field
                            v-model="props.item.adjust"
                            single-line
                            counter
                          ></v-text-field>
                        </template>
                      </v-edit-dialog>
                    </template>

                    <template v-slot:top>
                      <v-toolbar>
                        <v-toolbar-title>Detail AHS</v-toolbar-title>
                        <v-divider
                          class="mx-4"
                          inset
                          vertical
                        ></v-divider>
                        <v-btn color="blue" dark class="mb-2" @click="saveAdjust(filterMaterialsAll)">Save</v-btn>
                      </v-toolbar>
                    </template>

                    </v-data-table>
                </v-tab-item> -->
              </v-tabs>
            </v-card>
          </template>
        </v-card>
      </v-dialog>
    </v-toolbar>

    <v-expansion-panels>
      <v-expansion-panel v-for="data in filtered" :key="data.name">
          <v-expansion-panel-header>
            <v-layout row wrap :class="`pa-3 ahs`">
              <v-flex xs2>
                <div class="caption grey--text">ID RAB</div>
                <div>{{ data.kode }}</div>
              </v-flex>
              <v-flex xs3>
                <div class="caption grey--text">Project</div>
                <div>{{ data.name }}</div>
              </v-flex>
              <v-flex xs2>
                <div class="caption grey--text">Nominal</div>
                <div>Rp. {{ data.total_rab }}</div>
              </v-flex>
              <v-flex xs3>
                <div class="caption grey--text">Description</div>
                <div>{{ data.desc }}</div>
              </v-flex>
              <v-flex xs2>
                <div class="caption grey--text">Actions</div>
                <v-icon color="green" @click="itemPanelsStructure(data)">edit</v-icon>
                <v-icon color="red" @click="itemPanelsStructure(data);dialog2=true">delete</v-icon>
              </v-flex>
            </v-layout>
            
            <template v-slot:actions>
              <v-icon color="cyan" @click="itemPanelsStructure(data)">expand_more</v-icon>
            </template>
          </v-expansion-panel-header>
          <v-expansion-panel-content class="grey--text">
            
            <v-expansion-panels>
              <v-expansion-panel v-for="data in Structure" :key="data.id_structure_details">
                  <v-expansion-panel-header>
                    <v-layout row wrap>
                      <v-flex>
                        <div class="subtitle-2 black--text">{{data.structure}}</div>
                      </v-flex>
                      <v-flex xs12 sm12 md1>
                        <v-icon color="light-blue darken-4" @click="itemPanelsStructureHandler(data);dialog3=true">delete</v-icon>
                      </v-flex>
                    </v-layout>
                    
                    <template v-slot:actions>
                      <v-icon color="light-blue darken-4" @click="itemPanelsGroups(data)">expand_more</v-icon>
                    </template>
                  </v-expansion-panel-header>
                  <v-expansion-panel-content class="grey--text">

                    <v-expansion-panels>
                      <v-expansion-panel v-for="data in Groups" :key="data.id_group_details">
                          <v-expansion-panel-header>
                            <v-layout row wrap>
                              <v-flex>
                                <div class="subtitle-2 black--text">{{data.group}}</div>
                              </v-flex>
                              <v-flex xs12 sm12 md1>
                                <v-icon color="light-blue darken-2" @click="itemPanelsGroupHandler(data);dialog4=true">delete</v-icon>
                              </v-flex>
                            </v-layout>
                            
                            <template v-slot:actions>
                              <v-icon color="light-blue darken-2" @click="itemPanelsTask(data)">expand_more</v-icon>
                            </template>
                          </v-expansion-panel-header>
                          <v-expansion-panel-content class="grey--text">
                            
                            <v-expansion-panels>
                              <v-expansion-panel v-for="data in TaskSub" :key="data.id_sub_details">
                                  <v-expansion-panel-header>
                                    <v-layout row wrap>
                                      <v-flex>
                                        <div class="subtitle-2 black--text">{{data.task}}</div>
                                      </v-flex>
                                      <v-flex xs12 sm12 md1>
                                        <v-icon color="cyan accent-4" @click="itemPanelsTaskHandler(data);dialog5=true">delete</v-icon>
                                      </v-flex>
                                    </v-layout>
                                    
                                    <template v-slot:actions>
                                      <v-icon color="cyan accent-4" @click="itemPanelsDetail(data)">expand_more</v-icon>
                                    </template>
                                  </v-expansion-panel-header>
                                  <v-expansion-panel-content class="grey--text">

                                    <v-expansion-panels>
                                      <v-expansion-panel v-for="data in details" :key="data.id_rab_details">
                                          <v-expansion-panel-header>
                                            <v-layout row wrap v-if="data.id_ahs != null">
                                              <v-flex>
                                                <div class="caption grey--text">Task</div>
                                                <div>{{ data.ahs }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Price</div>
                                                <div>Rp. {{ data.price }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Satuan</div>
                                                <div>{{ data.satuan }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Status</div>
                                                <div>{{ data.status }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Volume</div>
                                                <div>{{ data.volume }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Coefficient</div>
                                                <div>{{ data.coefficient }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Sub Total</div>
                                                <div>Rp. {{ data.sub_total }}</div>
                                              </v-flex>
                                              <v-flex xs12 sm12 md1>
                                                <v-icon color="light-blue lighten-2" @click="itemPanelsDetailTask(data);dialog6=true">delete</v-icon>
                                              </v-flex>
                                            </v-layout>

                                            <v-layout row wrap v-if="data.id_ahs_adjust != null">
                                              <v-flex>
                                                <div class="caption grey--text">Task</div>
                                                <div>{{ data.ahs_adjust }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Price</div>
                                                <div>Rp. {{ data.price_adjust }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Satuan</div>
                                                <div>{{ data.satuan_adjust }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Status</div>
                                                <div>{{ data.status_adjust }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Volume</div>
                                                <div>{{ data.volume }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Coefficient</div>
                                                <div>{{ data.coefficient }}</div>
                                              </v-flex>
                                              <v-flex>
                                                <div class="caption grey--text">Sub Total</div>
                                                <div>Rp. {{ data.sub_total }}</div>
                                              </v-flex>
                                              <v-flex xs12 sm12 md1>
                                                <v-icon color="light-blue lighten-2" @click="itemHandler2(data)">delete</v-icon>
                                              </v-flex>
                                            </v-layout>
                                           
                                          </v-expansion-panel-header>
                                          <v-expansion-panel-content class="grey--text">
                                          </v-expansion-panel-content>
                                      </v-expansion-panel>
                                    </v-expansion-panels>

                                  </v-expansion-panel-content>
                              </v-expansion-panel>
                            </v-expansion-panels>

                          </v-expansion-panel-content>
                      </v-expansion-panel>
                    </v-expansion-panels>

                  </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>

          </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>

    <v-dialog v-model="dialog2" max-width="290px">
      <v-card>
        <v-card-title class="headline">Confirmation</v-card-title>
          <v-card-text>Are you sure want to delete this RAB?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(rab.id_rab)">Yes</v-btn>
          <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog3" max-width="290px">
      <v-card>
        <v-card-title class="headline">Confirmation</v-card-title>
          <v-card-text>Are you sure want to delete this structure?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog3 = false; deleteStructureDetails(detail.id_structure_details)">Yes</v-btn>
          <v-btn color="red darken-1" text @click="dialog3 = false">No</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog4" max-width="290px">
      <v-card>
        <v-card-title class="headline">Confirmation</v-card-title>
          <v-card-text>Are you sure want to delete this floor?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog4 = false; deleteGroupDetails(detail.id_group_details)">Yes</v-btn>
          <v-btn color="red darken-1" text @click="dialog4 = false">No</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog5" max-width="290px">
      <v-card>
        <v-card-title class="headline">Confirmation</v-card-title>
          <v-card-text>Are you sure want to delete this task group?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog5 = false; deleteTaskDetails(detail.id_sub_details)">Yes</v-btn>
          <v-btn color="red darken-1" text @click="dialog5 = false">No</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog6" max-width="290px">
      <v-card>
        <v-card-title class="headline">Confirmation</v-card-title>
          <v-card-text>Are you sure want to delete this task?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="dialog6 = false; deleteDetail(rab_details.id_rab_details)">Yes</v-btn>
          <v-btn color="red darken-1" text @click="dialog6 = false">No</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>
import Controller from './../service/Project'
import ahsController from './../service/AHS'
import rabController from './../service/RAB'
import structure from './../service/Structure'
import groups from './../service/Group'
import task from './../service/TaskSub'
import adjust from './../service/AHSAdjust'
import detail from './../service/RABDetails'
import job from './../service/Job'

  export default {
    data (){
      return{
        snack: false,
        snackColor: '',
        snackText: '',
        
        dialog: false,
        dialog2: false,
        dialog3: false,
        dialog4: false,
        dialog5: false,
        dialog6: false,
        dialog7: false,
        dialog8: false,
        dialog9: false,
        dialog10: false,
        dialog11: false,

        menu: false,
        tambah: false,
        tambahS: false,
        tambahF: false,
        tambahT: false,
        tambahAdjust: false,

        select: null,
        search:'',
        jenis:'',
        sub_item: '',
        gedung:'',

        job:[],
        structuredetails:[],
        groupdetails:[],
        tasksubdetails:[],

        details:[],
        project: [],
        ahs: [],
        adjust:[],
        detail_adjust:[],

        RAB:[],
        detailsData: [],

        filterAHSAll:[],
        filterAHSAdjust:[],
        filterMaterialsAll:[],

        detail:{
          id_structure_details: '',
          id_group_details:'',
          id_sub_details:'',
          id_rab_details:''
        },

        structure_unit:{
          id_structure: '',
          name : '',
        },
        group_unit:{
          id_structure:'',
          id_group: '',
          structure:'',
          groups:'',
        },
        tasksub_unit:{
          id_structure:'',
          id_groups:'',
          id_sub:'',
          structure:'',
          groups:'',
          name:'',
        },

        Structure:[],
        structure:[],
        structure_data:{
          id_structure: '',
          name : '',
        },
        structureDefault:
        {
          id_structure: '',
          name : '',
        },

        Groups:[],
        sub: [],
        group_data:{
          id_structure:'',
          id_group: '',
          structure:'',
          groups:'',
        },
        groupDefault:{
          id_structure:'',
          id_group: '',
          structure:'',
          groups:'',
        },

        TaskSub:[],
        type:[],
        task:[],
        tasksub_data:{
          id_structure:'',
          id_groups:'',
          id_sub:'',
          structure:'',
          groups:'',
          name:'',
        },
        tasksubDefault:{
          id_structure:'',
          id_groups:'',
          id_sub:'',
          structure:'',
          groups:'',
          name:'',
        },
        
        rab_details:{
          id_ahs:'',
          sub_total: 0,
          volume: 0,
          coefficient: 1,
          hp: 0,
          id_structure: '',
          id_groups:'',
          id_sub:'',
          structure:'',
          groups:'',
          name:'',
        },

        rabDetailsDefault:{
          id_ahs:'',
          sub_total: 0,
          volume: 0,
          coefficient: 1,
          hp: 0,
          id_structure: '',
          id_groups:'',
          id_sub:'',
          structure:'',
          groups:'',
          name:'',
        },

        AHSAdjustDefault: {
          id_ahs_adjust:'',
          adjusment:0,
          total_labor:0,
          total_material:0,
          total:0
        },

        ahs_adjust:{
          id_ahs_adjust:'',
          adjusment:0,
          total_labor:0,
          total_material:0,
          total:0
        },

        AHS:{
          id_ahs:'',
          total:0,
        },
        AHSDefault:{
          id_ahs:'',
          total:0,
        },
        rab:{
          id_rab:'',
          id_project:'',
          id_ahs:'',
          coefficient: 1,
          total_rab:0,
          kode:'',
          desc: '',
        },

        RABDefault:{
          id_rab:'',
          id_project:'',
          id_ahs:'',
          coefficient: 1,
          total_rab:0,
          kode:'',
          desc: '',
        },

        Project: {
          name:'',
          date: new Date().toISOString().substr(0, 10),
          address: '',
          contact: '',
          id_project: '',
          phone: '',
        },
        headers_filter_materials: [
          {
            text: 'ID',
            align: 'left',
            sortable: false,
            value: 'kode',
          },
          {
            text: 'Status',
            align: 'left',
            sortable: false,
            value: 'status',
          },
          {
            text: 'Name',
            align: 'left',
            sortable: false,
            value: 'name',
          },
          { 
            sortable: false,
            text: 'Type', 
            value: 'type'
          },
          {
            sortable: false,
            text: 'Price',
            value: 'price'
          },
          {
            sortable: false,
            text: 'Satuan',
            value: 'satuan'
          },
          {
            sortable: false,
            text: 'Adjusment',
            value: 'adjust'
          },
        ],
        headers_structure: [
          { 
            text: 'ID', align: 'left', sortable: false, value: 'id_structure',
          },
          { 
            text: 'Building', align: 'left', sortable: false, value: 'name',
          },
          {
            text: 'Action', align: 'left', sortable: false, value: 'action'
          }
        ],
        headers_group: [
          { 
            text: 'ID', align: 'left', sortable: false, value: 'id_group',
          },
          { 
            text: 'Floor', align: 'left', sortable: false, value: 'name',
          },
          {
            text: 'Action', align: 'left', sortable: false, value: 'action'
          }
        ],
        headers_sub: [
          { 
            text: 'ID', align: 'left', sortable: false, value: 'id_sub',
          },
          { 
            text: 'Sub Task', align: 'left', sortable: false, value: 'name',
          },
          {
            text: 'Action', align: 'left', sortable: false, value: 'action'
          }
        ],
        headers_detail_floor: [
          { 
            text: 'ID', align: 'left', sortable: false, value: 'id_groups',
          },
          { 
            text: 'Building', align: 'left', sortable: false, value: 'structure',
          },
          { 
            text: 'Floor', align: 'left', sortable: false, value: 'groups',
          },
          {
            text: 'Task Sub', align: 'left', sortable: false, value: 'action'
          }
        ],
        headers_detail_task: [
          { 
            text: 'ID', align: 'left', sortable: false, value: 'id_sub',
          },
          { 
            text: 'Building', align: 'left', sortable: false, value: 'structure',
          },
          { 
            text: 'Floor', align: 'left', sortable: false, value: 'groups',
          },
          {
            text: 'Task Sub', align: 'left', sortable: false, value: 'name'
          },
          {
            text: 'Detail', align: 'left', sortable: false, value: 'action'
          }
        ],
        headers_detail_building: [
          { 
            text: 'ID', align: 'left', sortable: false, value: 'id_structure',
          },
          { 
            text: 'Building', align: 'left', sortable: false, value: 'name',
          },
          { 
            text: 'Floor', align: 'left', sortable: false, value: 'action',
          },
        ],
        tab : 'tab-1'
      }
    },
    mounted(){
      this.getallDetails()
      this.getallItem()
      this.getallAHS()
      this.getallRAB()
      this.getGroup()
      this.getTaskSub()
      this.getStructure()
      this.getAdjust()
      this.getJob()
      // this.getStructureDetails()
    },
    computed: {
      filtered:function(){
        return this.RAB.filter((data)=>{
          return data.name.match(this.search);
        });
      }
    },
    methods: {
      async saveAdjust(filterMaterialsAll)
      {
        let data = this.ahs.find(obj=>obj.id_ahs == this.AHS.id_ahs)
        console.log('Data')
        console.log(data)

        let temp = 0
        let count = 0
        
        this.AHS = data
        
        for(let detail of this.filterMaterialsAll)
        {
          if(detail.status == "labor")
            this.ahs_adjust.total_labor += detail.price * detail.adjust
          else
            this.ahs_adjust.total_material += detail.price * detail.adjust
            
          this.ahs_adjust.total = this.ahs_adjust.total_labor + this.ahs_adjust.total_material
          temp = parseInt(temp) + parseInt(detail.adjust)
          count = parseInt(count+1,10)

          let each_detail = {
            id_material     : detail.id_material,
            sub_adjusment   : detail.adjust,
            sub_total       : detail.adjust * detail.price,
          }
          this.detail_adjust.push(each_detail)
        }
          // console.log('Detail Adjust')
          // console.log(this.detail_adjust)
          // console.log('count')
          // console.log(count)
          // console.log('Adjustment')
          // console.log(temp)
          // console.log('Total Material AHS Adjust')
          // console.log(this.ahs_adjust.total_material)
          // console.log('Total Labor AHS Adjust')
          // console.log(this.ahs_adjust.total_labor)
          // console.log('Total AHS Adjust')
          // console.log(this.ahs_adjust.total)

        try{
          const payload = {
            id_project      : this.rab.id_project,
            id_job          : this.AHS.id_job,
            id_sub          : this.AHS.id_sub,
            adjustment      : temp/count,
            total_labor     : this.ahs_adjust.total_labor,
            total_material  : this.ahs_adjust.total_material,
            total           : this.ahs_adjust.total,
            detail          : this.detail_adjust
          }
          await adjust.add(payload)
          this.getAdjust()
          this.tab = 'tab-5'
          this.tambahAdjust = true
          this.tambah = false
          this.filterMaterialsAll=[]
        }catch(err){
          console.log(err);
        }
      },
      // changeTab()
      // {
      //   this.tab = 'tab-6'
      //   let filterMaterials=[]
      //   let data = this.ahs.find(obj=>obj.id_ahs == this.AHS.id_ahs)

      //   for(let materials of data.ahs_details.data)
      //   {
      //     let each_materials = {
      //       id_ahs        : materials.id_ahs,
      //       id_material   : materials.id_material,
      //       kode          : materials.kode,
      //       name          : materials.name,
      //       type          : materials.type,
      //       satuan        : materials.satuan,
      //       price         : materials.price,
      //       spesification : materials.spesification,
      //       status        : materials.status,
      //       store         : materials.store,
      //       adjust        : 1
      //     }
      //     filterMaterials.push(each_materials)
      //   }
      //   this.filterMaterialsAll = data.ahs_details.data
      // },
      async getAdjust()
      {
        try{
          this.adjust = (await adjust.get()).data
        }catch(err){
          console.log(err)
        }
      },
      save (props) {
        console.log("Array Material")
        console.log(this.filterMaterialsAll)

        console.log('After Set')
        console.log(this.filterMaterialsAll)
      },
      itemStructure(item)
      {
        this.structure_unit = item
        console.log(this.structure_unit)
      },
      itemAdjust(item)
      {
        console.log('ini permasalahannya')
        console.log(item)
        // this.ahs_adjust = item
      },
      filterAHS(item)
      {
        this.tasksub_unit = item 

        let filterAHS=[]
        for(let ahs_data of this.ahs.filter(obj=>obj.id_sub == item.id_sub))
        {
          let each_ahs = {
            id_ahs          : ahs_data.id_ahs,
            kode            : ahs_data.kode,
            id_job          : ahs_data.id_job,
            id_sub          : ahs_data.id_sub,
            total_labor     : ahs_data.total_labor,
            total_material  : ahs_data.total_material,
            total           : ahs_data.total,
            name            : ahs_data.name,
            detail          : ahs_data.ahs_details 
          }
          filterAHS.push(each_ahs)
        }
        this.filterAHSAll = filterAHS
      },
      filterAHSAdjustment(item)
      {
        this.tasksub_unit = item 
        
        let filterAHS=[]
        console.log('cek')
        for(let ahs_data of this.adjust.filter(obj=>obj.id_sub == item.id_sub))
        {
          let data = this.job.find(obj=>obj.id_job == ahs_data.id_job)
          console.log(data)
          let each_ahs = {
            id_ahs_adjust   : ahs_data.id_ahs_adjust,
            // kode            : ahs_data.kode,
            id_job          : ahs_data.id_job,
            id_sub          : ahs_data.id_sub,
            adjustment      : ahs_data.adjustment,
            // total_labor     : ahs_data.total_labor,
            // total_material  : ahs_data.total_material,
            total           : ahs_data.total,
            name            : data.name,
            // detail          : ahs_data.ahs_details 
          }
          filterAHS.push(each_ahs)
        }
        this.filterAHSAdjust = filterAHS
        console.log(this.filterAHSAdjust)
      },
      itemGroups(item)
      {
        this.group_unit = item
        console.log(this.group_unit)
      },
      itemHandlerSub(item)
      {
        this.tasksub_data = item
        console.log(this.tasksub_data)
      },
      itemHandlerGroup(item)
      {
        this.group_data = item
        console.log(this.group_data)
      },
      itemHandlerStructure(item)
      {
        this.structure_data = item
        console.log(this.structure_data)
      },
      itemHandler(item){
        this.rab_details = item.rab_details
        console.log(this.rab_details)
      },
      itemPanelsStructure(item){
        this.rab = item 

        this.Structure = item.structure.data
        console.log('Structure')
        console.log(this.Structure)
        console.log('masuk kesini')
      },
      itemPanelsGroups(item)
      {
        console.log('Groups')
        this.Groups = item.group.data
      },
      itemPanelsTask(item)
      {
        console.log('Task')
        this.TaskSub = item.task_sub.data
      },
      itemPanelsDetail(item)
      {
        console.log('Detail')
        this.details = item.rab_details.data
        console.log(this.details)
      },
      itemPanelsStructureHandler(item)
      {
        console.log('Structure Item')
        this.detail = item 
        console.log(this.detail)
      },
      itemPanelsGroupHandler(item)
      {
        console.log('Group Item')
        this.detail = item
      },
      itemPanelsTaskHandler(item)
      {
        console.log('Task Item')
        this.detail  = item
      },
      itemPanelsDetailTask(item)
      {
        console.log('Detail Item')
        this.rab_details = item 
        console.log(this.rab_details)
      },
      itemDetailHandler(item){
        this.detail = item
        console.log(this.detail)
      },
      async addstructure()
      {
        var object = this.structure_data
        let data = this.structure.find(obj=>obj.id_structure == this.structure_data.id_structure)
        object.id_structure = data.id_structure
        object.name = data.name
        this.Structure.push(JSON.parse(JSON.stringify(object)))
        console.log('Detail Structure')
        console.log(this.Structure)
      },
      deletestructure(index){
        this.Structure.splice(this.Structure.indexOf(index),1)
        for(let group of this.Groups)
        {
          if(group.id_structure == index.id_structure)
            this.Groups.splice(this.Groups.indexOf(group))
        }
        for(let task of this.TaskSub)
        {
          if(task.id_structure==index.id_structure)
            this.TaskSub.splice(this.TaskSub.indexOf(task))
        }
        for(let detail of this.details)
        {
          if(detail.id_structure==index.id_structure)
            this.details.splice(this.details.indexOf(detail))
        }
        this.Structure=[...this.Structure]
        this.Groups=[...this.Groups]
        this.TaskSub=[...this.TaskSub]
        this.details=[...this.details]
      },
      async addfloor()
      {
        var object = this.group_data
        let data = this.sub.find(obj=>obj.id_group == this.group_data.id_group)
        let dataS = this.Structure.find(obj=>obj.id_structure == this.structure_unit.id_structure)
        object.id_structure = this.structure_unit.id_structure
        object.id_groups  = data.id_group
        object.structure  = dataS.name
        object.groups = data.name
        object.name = data.name
        this.Groups.push(JSON.parse(JSON.stringify(object)))
        console.log('Detail Group')
        console.log(this.Groups)
      },
      deletefloor(index){
        this.Groups.splice(this.Groups.indexOf(index),1)
        for(let task of this.TaskSub)
        {
          if(task.id_groups==index.id_group)
            this.TaskSub.splice(this.TaskSub.indexOf(task))
        }
        for(let detail of this.details)
        {
          if(detail.id_groups==index.id_group)
            this.details.splice(this.details.indexOf(detail))
        }
        this.Groups=[...this.Groups]
        this.TaskSub=[...this.TaskSub]
        this.details=[...this.details]
      },
      async addtasksub()
      {
        var object = this.tasksub_data
        console.log("Detail Group in Task")
        let data = this.type.find(obj=>obj.id_sub == this.tasksub_data.id_sub)
        console.log(data)
        object.id_structure = this.group_unit.id_structure
        object.id_groups = this.group_unit.id_group
        object.id_sub = data.id_sub
        let dataS = this.structure.find(obj=>obj.id_structure == this.group_unit.id_structure)
        console.log(dataS)
        object.structure = dataS.name
        let dataG = this.sub.find(obj=>obj.id_group == this.group_unit.id_group)
        console.log(dataG)
        object.groups = dataG.name
        object.name = data.name
        this.TaskSub.push(JSON.parse(JSON.stringify(object)))
        console.log('Detail Task')
        console.log(this.TaskSub)
      },
      deletetasksub(index){
        this.TaskSub.splice(this.TaskSub.indexOf(index),1)
        for(let detail of this.details)
        {
          if(detail.id_sub==index.id_sub)
            this.details.splice(this.details.indexOf(detail))
        }
        this.TaskSub=[...this.TaskSub]
        this.details=[...this.details]
      },
      async addList()
      {
        var object = this.rab_details
        console.log(this.adjust)
        console.log('object')
        console.log(object)
        if(this.ahs_adjust.id_ahs_adjust != '')
        {
          // let dataA = this.filterAHSAdjust.find(obj=>obj.id_ahs_adjust == this.ahs_adjust.id_ahs_adjust)

          let dataS = this.filterAHSAdjust.find(obj=>obj.id_ahs_adjust == this.ahs_adjust.id_ahs_adjust)
          console.log(dataS)
          object.coefficient = dataS.adjustment
          object.id_ahs_adjust = dataS.id_ahs_adjust
          object.id_ahs = null
          object.ahs_adjust = dataS.name
          object.ahs = ''
          object.status = dataS.status

          console.log('ID Job')

          if(object.status == 'Price')
          {
            object.volume = this.rab_details.volume
            object.sub_total_adjust  = object.coefficient * dataS.total
            this.rab_details.hp = dataS.total * object.volume
            object.hp = this.rab_details.hp
          }
          else
          {
            object.volume = object.coefficient * this.rab_details.volume
            object.sub_total_adjust = dataS.total
            this.rab_details.hp = dataS.total * object.volume 
            object.hp = this.rab_details.hp
          }
          console.log('masuk ahs adjust')
          // cek = true
          object.sub_total = 0

        }
        if(this.ahs_adjust.id_ahs_adjust == '') 
        {
          let data = this.filterAHSAll.find(obj=>obj.id_ahs == this.AHS.id_ahs)
          console.log(data)
          object.id_ahs = data.id_ahs
          object.id_ahs_adjust = null
          object.ahs = data.name
          object.ahs_adjust=''

          object.status = data.status
          if(object.status == 'Price')
          {
            object.volume = this.rab_details.volume
            object.sub_total  = object.coefficient * data.total
            this.rab_details.hp = object.sub_total * object.volume
            object.hp = this.rab_details.hp
          }
          else
          {
            object.volume = object.coefficient * this.rab_details.volume
            object.sub_total = data.total
            this.rab_details.hp = object.volume * object.sub_total
            object.hp = this.rab_details.hp
          }
          console.log('masuk ahs')
          object.sub_total_adjust = 0
          object.coefficient = this.rab_details.coefficient
        }
        object.id_structure = this.tasksub_unit.id_structure
        object.id_groups = this.tasksub_unit.id_groups
        object.id_sub = this.tasksub_unit.id_sub
        let datas = this.structure.find(obj=>obj.id_structure == this.tasksub_unit.id_structure)
        console.log(datas)
        object.structure = datas.name
        let dataG = this.sub.find(obj=>obj.id_group == this.tasksub_unit.id_groups)
        console.log(dataG)
        object.groups = dataG.name
        let dataT = this.type.find(obj=>obj.id_sub == this.tasksub_unit.id_sub)
        console.log(dataT)
        object.name = dataT.name
        
        this.rab.total_rab = parseInt(this.rab_details.hp + this.rab.total_rab,10);

        this.details.push(JSON.parse(JSON.stringify(object)))
        this.tambah = false
        this.tambahAdjust = false
        console.log('Detail AHS')
        console.log(this.details)
        this.ahs_adjust = Object.assign({},this.AHSAdjustDefault)
        console.log('cek ahs adjust')
        console.log(this.ahs_adjust)
        this.AHS = Object.assign({},this.AHSDefault)
        console.log('cek ahs')
        console.log(this.AHS)

      },
      deleteList(index){
        this.rab.total_rab = parseInt(this.rab.total_rab - index.hp,10)
        this.details.splice(this.details.indexOf(index),1)
        this.details=[...this.details]
      },
      getSelectedIndex(){
        this.index = this.ahs.map(function(e) { return e.id_ahs; }).indexOf(this.AHS.id_ahs);
        console.log(this.index)
      },
      getSelectedIndexAdjust(){
        this.index = this.filterAHSAdjust.map(function(e) { return e.id_ahs_adjust; }).indexOf(this.ahs_adjust.id_ahs_adjust);
        console.log(this.index)
      },
      async addTaskSub()
      {
        try{
          const payload = {
            name :  'Pekerjaan' + ' ' + this.sub_item,
          }
          await task.add(payload)
          this.getTaskSub()
          this.sub_item = ''
        }catch(err){
          console.log(err)
        }
      },
      async updateTaskSub(id){
        try{
          const payload = {
            name        : this.tasksub_data.name
          }
          await task.update(payload,id)
          this.getTaskSub()
          this.close()
        }catch(err){
          console.log(err)
        }
      },
      async deleteTaskSub(id){
        try{
          await task.delete(id).data
          this.getTaskSub()
        }catch(err){
          console.log(err)
        }
      },
      async getTaskSub(){
        try{
          this.type = (await task.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallDetails(){
        try{
          this.detailsData = (await rabController.getallDetails()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallAHS(){
        try{
          this.ahs = (await ahsController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallItem(){
        try{
          this.project = (await Controller.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallRAB(){
        try{
          this.RAB = (await rabController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async addGroup()
      {
        try{
          const payload = {
            name : 'Lantai' + ' ' + this.sub_item,
          }
          await groups.add(payload)
          this.getGroup()
          this.sub_item = ''
        }catch(err){
          console.log(err);
        }
      },
      async updateGroup(id){
        try{
          const payload = {
            name        : this.group_data.name
          }
          await groups.update(payload,id)
          this.getGroup()
          this.close()
        }catch(err){
          console.log(err)
        }
      },
      async deleteGroup(id){
        try{
          await groups.delete(id).data
          this.getGroup()
        }catch(err){
          console.log(err)
        }
      },
      async getGroup(){
        try{
          this.sub = (await groups.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async addAllItem(){
        try{
          const payload = {
            id_project        : this.rab.id_project,
            kode              : this.rab.kode,
            desc              : this.rab.desc,
            total_rab         : this.rab.total_rab,
            detail_structure  : this.Structure,
            detail_group      : this.Groups,
            detail_task       : this.TaskSub,
            detail            : this.details,
          }
          await rabController.addAllItem(payload)
          this.close()
          this.getallRAB()
          this.refresh()
        }catch(err){
          console.log(err);
        }
      },
      async updateItem(id){
        try{
            const payload = {
              id_project    : this.rab.id_project,
              id_ahs        : this.rab.id_ahs,
              kode          : this.rab.kode,
              sub           : this.rab.sub,
              desc          : this.rab.desc,
              total_rab     : this.rab.total_rab,
              detail        : this.details
            } 
            await rabController.updateItem(payload,id)
            this.getallRAB()
            this.close()
            this.refresh()
        }catch(err){
          console.log(err);
        }
      },
      async deleteItem(id){
        try{
          await rabController.deleteItem(id).data
          this.getallRAB()
          // this.rab = Object.assign({},this.RABDefault)
          // this.structure_data = Object.assign({},this.structureDefault)
          // this.group_data = Object.assign({},this.groupDefault)
          // this.tasksub_data = Object.assign({},this.tasksubDefault)
          // this.rab_details = Object.assign({},this.rabDetailsDefault)
        }catch(err){
          console.log(err)
        }
      },
      async deleteDetail(id){
        try{
          await rabController.deleteDetail(id).data
          this.getallDetails()
          this.getallRAB()
        }catch(err){
          console.log(err)
        }
      },
      async updateDetail(id){
        try{
          const payload = {
            coefficient   : this.detail.coefficient,
            volume        : this.detail.volume
          }
          await rabController.updateDetail(payload,id)
          this.getallDetails()
          this.getallRAB()
          this.close()
        }catch(err){
          console.log(err)
        }
      },
      async addStructure()
      {
        try{
          const payload = {
            name :  'Gedung' + ' ' + this.gedung,
          }
          await structure.add(payload)
          this.getStructure()
          this.gedung = ''
        }catch(err){
          console.log(err)
        }
      },
      async updateStructure(id){
        try{
          const payload = {
            name        : this.structure_data.name
          }
          await structure.update(payload,id)
          this.getStructure()
          this.close()
        }catch(err){
          console.log(err)
        }
      },
      async deleteStructure(id){
        try{
          await structure.delete(id).data
          this.getStructure()
        }catch(err){
          console.log(err)
        }
      },
      async getStructure(){
        try{
          this.structure = (await structure.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async deleteStructureDetails(id)
      {
        console.log('Cek id')
        console.log(id)
        try{
          await detail.deleteS(id).data
          this.getallRAB()
        }catch(err){
          console.log(err)
        }
      },
      async deleteGroupDetails(id)
      {
        console.log('Cek id')
        console.log(id)
        try{
          await detail.deleteG(id).data
          this.getallRAB()
        }catch(err){
          console.log(err)
        }
      },
      async deleteTaskDetails(id)
      {
        console.log('Cek id')
        console.log(id)
        try{
          await detail.deleteT(id).data
          this.getallRAB()
        }catch(err){
          console.log(err)
        }
      },
      async getJob()
      {
        try{
          this.job = (await job.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      refresh(){
        // this.deleteList()
        // this.rab = ''
      },
      close () {
        this.dialog = false
        this.dialog3 = false
        this.dialog4 = false
        this.dialog5 = false
        this.dialog6 = false
        this.dialog7 = false
        this.dialog8 = false
        this.dialog9 = false
        this.dialog10 = false
        this.dialog11 = false
      },
    }
  }
</script>

<style>
.mytable table tr {
    /* background-color: gainsboro; */
}
</style>